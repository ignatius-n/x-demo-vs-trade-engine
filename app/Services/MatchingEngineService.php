<?php

namespace App\Services;

use App\Enums\SideOptionsEnum;
use App\Enums\StatusOptionsEnum;
use App\Models\Order;
use App\Models\Trade;
use Illuminate\Support\Facades\DB;

class MatchingEngineService
{
    public function match(Order $incoming): void
    {
        DB::transaction(function () use ($incoming) {
            while ($incoming->status === StatusOptionsEnum::OPEN->value && $incoming->amount > 0) {
                $counter        = Order::where('symbol', $incoming->symbol)
                    ->where('side', $incoming->side === SideOptionsEnum::BUY->value ? SideOptionsEnum::SELL->value : SideOptionsEnum::BUY->value)
                    ->where('status', StatusOptionsEnum::OPEN->value)
                    ->where(fn($q) => $incoming->side === SideOptionsEnum::BUY->value
                        ? $q->where('price', '<=', $incoming->price)
                        : $q->where('price', '>=', $incoming->price))
                    ->orderBy('price', $incoming->side === SideOptionsEnum::BUY->value ? 'asc' : 'desc')
                    ->orderBy('created_at')
                    ->lockForUpdate()
                    ->first();


                if (!$counter) break;


                $matchedAmount  = min($incoming->amount, $counter->amount);
                $price          = $counter->price;


                // Idempotency guard
                if (Trade::where('buy_order_id', $incoming->id)
                    ->where('sell_order_id', $counter->id)
                    ->exists()) {
                    break;
                }


                Trade::create([
                    'buy_order_id'  => $incoming->side === SideOptionsEnum::BUY->value ? $incoming->id : $counter->id,
                    'sell_order_id' => $incoming->side === SideOptionsEnum::SELL->value ? $incoming->id : $counter->id,
                    'price'         => $price,
                    'amount'        => $matchedAmount,
                    'commission'    => app(CommissionService::class)->calculate($matchedAmount * $price)
                ]);


                $payload            = ['status' => StatusOptionsEnum::FILLED->value];
                $incoming->decrement('amount', $matchedAmount);
                $counter->decrement('amount', $matchedAmount);

                if ($incoming->amount === 0) $incoming->update($payload);
                if ($counter->amount === 0) $counter->update($payload);
            }
        }, 5); // retry on deadlock
    }
}
