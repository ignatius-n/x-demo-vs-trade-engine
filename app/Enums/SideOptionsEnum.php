<?php

namespace App\Enums;

enum SideOptionsEnum: string
{
    case BUY            = 'buy';
    case SELL           = 'sell';

    /**
     * @return string
     */
    public function getName(): string
    {
        return match ($this) {
            self::BUY   => 'Buy',
            self::SELL  => 'Sell',
            default     => 'Unknown',
        };
    }
}
