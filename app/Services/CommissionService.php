<?php

namespace App\Services;

class CommissionService
{
    public function calculate(float $usd): float
    {
        try {
            return round($usd * 0.015, 2);
        }
        catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}
