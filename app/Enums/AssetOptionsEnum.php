<?php

namespace App\Enums;

enum AssetOptionsEnum: string
{
    case BTC    = 'BTC';
    case ETH    = 'ETH';


    /**
     * @return string
     */
    public function getName(): string
    {
        return match ($this) {
            self::BTC   => 'Bitcoin',
            self::ETH   => 'Ethereum',
            default     => 'Unknown',
        };
    }

    /**
     * @return string
     */
    public function getIcon(): string
    {
        return match ($this) {
            self::BTC   => asset('assets/btc.png'),
            self::ETH   => asset('assets/eth.png'),
            default     => '',
        };
    }
}
