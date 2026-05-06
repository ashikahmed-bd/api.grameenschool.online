<?php

namespace App\Enums;

enum Provider: string
{
    case YOUTUBE = 'youtube';
    case VIMEO = 'vimeo';
    case S3 = 's3';
    case SELF = 'self';
}
