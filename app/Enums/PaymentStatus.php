<?php

namespace App\Enums;

enum PaymentStatus: string
{
    case CREATED = 'created';
    case PENDING = 'pending';
    case SUCCESS = 'success';
    case FAILED = 'failed';
    case CANCELLED = 'cancelled';
    case REFUNDED = 'refunded';
}
