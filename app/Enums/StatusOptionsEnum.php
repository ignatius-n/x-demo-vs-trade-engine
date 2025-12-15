<?php

namespace App\Enums;

enum StatusOptionsEnum: string
{
    case OPEN               = 'open';
    case FILLED             = 'filled';
    case CANCELED           = 'canceled';

    /**
     * @return string
     */
    public function getName(): string
    {
        return match ($this) {
            self::OPEN      => 'Open',
            self::FILLED    => 'Filled',
            self::CANCELED  => 'Canceled',
            default         => 'Unknown',
        };
    }
}
