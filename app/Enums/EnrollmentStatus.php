<?php

namespace App\Enums;

enum EnrollmentStatus: string
{
    case LOCKED    = 'locked';
    case ONGOING   = 'ongoing';
    case COMPLETED = 'completed';

    case EXPIRED   = 'expired';
    case CANCELLED = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::LOCKED    => 'Locked',
            self::ONGOING   => 'Ongoing',
            self::COMPLETED => 'Completed',
            self::EXPIRED   => 'Expired',
            self::CANCELLED => 'Cancelled',
        };
    }
}
