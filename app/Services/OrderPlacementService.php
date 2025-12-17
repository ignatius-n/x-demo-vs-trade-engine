<?php

namespace App\Services;

use App\Enums\SideOptionsEnum;
use App\Enums\StatusOptionsEnum;
use App\Models\Asset;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OrderPlacementService
{
    public function __construct(
        protected WalletService $walletService
    ) {}

    /**
     * Places a limit order atomically.
     *
     * Responsibilities:
     * - Validate balances
     * - Lock funds/assets
     * - Persist order
     * - Guarantee consistency under concurrency
     */
    public function place(User $user, string $symbol, string $side, float $price, float $amount): Order
    {
        return DB::transaction(function () use ($user, $symbol, $side, $price, $amount) {

            /**
             * Lock user row to prevent race conditions e.g. double-spend protection.
             */
            $user->lockForUpdate();

            if ($side === SideOptionsEnum::BUY->value) {
                $usdRequired = bcmul($price, $amount, 2);

                $this->walletService->lockUsd(
                    user: $user,
                    amount: $usdRequired
                );
            }

            if ($side === SideOptionsEnum::SELL->value) {
                $asset = Asset::where('user_id', $user->id)
                    ->where('symbol', $symbol)
                    ->lockForUpdate()
                    ->firstOrFail();

                $this->walletService->lockAsset(
                    asset: $asset,
                    amount: $amount
                );
            }

            /**
             * Create the order AFTER funds are secured.
             */
            return Order::create([
                'user_id' => $user->id,
                'symbol'  => $symbol,
                'side'    => $side,
                'price'   => $price,
                'amount'  => $amount,
                'status'  => StatusOptionsEnum::OPEN->value,
            ]);
        }, 5); // Retry on deadlock
    }
}
