<?php

use App\Enums\AssetOptionsEnum;
use App\Enums\SideOptionsEnum;

if (! function_exists('getAssetOptions')) {
    function getAssetOptions(): array
    {
        try {
            $symbols                            = [
                AssetOptionsEnum::BTC->value    => AssetOptionsEnum::BTC->getName(),
                AssetOptionsEnum::ETH->value    => AssetOptionsEnum::ETH->getName(),
            ];
            asort($symbols);
            return $symbols;
        }
        catch (Exception $e) {
            return [];
        }
    }
}

if (! function_exists('getSideOptions')) {
    function getSideOptions(): array
    {
        try {
            $sides                              = [
                SideOptionsEnum::BUY->value     => SideOptionsEnum::BUY->getName(),
                SideOptionsEnum::SELL->value    => SideOptionsEnum::SELL->getName(),
            ];
            asort($sides);
            return $sides;
        }
        catch (Exception $e) {
            return [];
        }
    }
}
