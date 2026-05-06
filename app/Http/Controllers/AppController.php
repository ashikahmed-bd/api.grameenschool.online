<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AppController extends Controller
{

    public function cta()
    {
        return [
            'title' => setting('cta.title') ?? '',
            'subtitle' => setting('cta.subtitle') ?? '',
            'app_links' => [
                'google_play' => setting('cta.app_links.google_play') ?? '',
                'app_store' => setting('cta.app_links.app_store') ?? '',
            ],
            'app_url' => Storage::disk(config('app.disk'))->url('app.png'),
            'social' => [
                'heading' => setting('cta.social.heading') ?? '',
                'description' => setting('cta.social.description') ?? '',
                'links' => [
                    'facebook' => setting('cta.social.links.facebook') ?? '',
                    'twitter' => setting('cta.social.links.twitter') ?? '',
                    'instagram' => setting('cta.social.links.instagram') ?? '',
                    'linkedin' => setting('cta.social.links.linkedin') ?? '',
                    'youtube' => setting('cta.social.links.youtube') ?? '',
                ],
            ],
        ];
    }
}
