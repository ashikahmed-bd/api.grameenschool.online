<?php

namespace App\Enums;

enum DiscountType: string
{
    case FIXED = 'fixed';
    case PERCENT = 'percent';

    // Optional: formatted label
    public function label(): string
    {
        return match($this) {
            self::FIXED => 'fixed',
            self::PERCENT => 'Percent',
        };
    }
}
