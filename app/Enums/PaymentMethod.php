<?php

namespace App\Enums;

enum PaymentMethod: string
{
    case BKASH = 'bkash';
    case NAGAD = 'nagad';
    case ROCKET = 'rocket';
    case UPAY = 'upay';
    case CARD = 'card';
    case SSL = 'sslcommerz';
    case BANK_TRANSFER = 'bank_transfer';
    case CASH = 'cash';
}
