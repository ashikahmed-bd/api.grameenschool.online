<?php

namespace App\Enums;

enum MeetStatus: string
{
    case SCHEDULED = 'scheduled';
    case STARTED = 'started';
    case ENDED = 'ended';
    case CANCELLED = 'cancelled';
}
