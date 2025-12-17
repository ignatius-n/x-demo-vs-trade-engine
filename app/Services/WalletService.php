<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\User;
use Exception;

class WalletService
{
    public function lockUsd(User $user, float $amount): void
    {
        try {
            if ($user->balance < $amount) {
                throw new \RuntimeException('Insufficient USD balance');
            }
            $user->decrement('balance', $amount);
        }
        catch (Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    /**
     * @throws Exception
     */
    public function lockAsset(Asset $asset, float $amount): void
    {
        try {
            if ($asset->amount < $amount) {
                throw new \RuntimeException('Insufficient asset balance');
            }
            $asset->decrement('amount', $amount);
            $asset->increment('locked_amount', $amount);
        }
        catch (Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}
