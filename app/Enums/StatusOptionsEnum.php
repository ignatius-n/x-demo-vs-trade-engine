<?php

namespace App\Enums;

enum StatusOptionsEnum: int
{
    case OPEN               = 1;
    case FILLED             = 2;
    case CANCELED           = 3;

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
