<?php

namespace App\Enums;

enum MeetProvider: string
{
    case GOOGLE_MEET = 'google_meet';
    case ZOOM = 'zoom';
    case JITSI = 'jitsi';
}
