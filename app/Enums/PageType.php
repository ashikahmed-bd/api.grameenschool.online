<?php

namespace App\Enums;

enum PageType: string
{
    case STATIC = 'static';
    case FOOTER = 'footer';
    case LINKS = 'links';
    case OFFERS = 'offers';
}
