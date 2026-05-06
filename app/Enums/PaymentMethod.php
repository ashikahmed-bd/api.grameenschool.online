<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case BKASH = 'bkash';
    case NAGAD = 'nagad';
    case CARD = 'card';
    case SSL = 'sslcommerz';
}

