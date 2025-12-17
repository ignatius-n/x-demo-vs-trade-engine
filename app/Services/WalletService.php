<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\User;

class WalletService
{
    public function lockUsd(User $user, float $amount): void
    {
        if ($user->balance < $amount) {
            throw new \RuntimeException('Insufficient USD balance');
        }

        $user->decrement('balance', $amount);
    }

    public function lockAsset(Asset $asset, float $amount): void
    {
        if ($asset->amount < $amount) {
            throw new \RuntimeException('Insufficient asset balance');
        }

        $asset->decrement('amount', $amount);
        $asset->increment('locked_amount', $amount);
    }
}
