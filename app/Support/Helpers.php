<?php

use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Storage;


if (! function_exists('convert_minutes_to_duration')) {
    function convert_minutes_to_duration($total_minutes, $format = '%02d:%02d:%02d'): string
    {
        if ($total_minutes < 0.0 || ! $total_minutes) {
            return '00:00:00';
        }

        $hours = floor($total_minutes / 60);
        $minutes = ($total_minutes % 60);
        $seconds = ($total_minutes * 60) % 60;

        return sprintf($format, $hours, $minutes, $seconds);
    }
}

if (! function_exists('convert_hours_to_duration')) {
    function convert_hours_to_duration($total_hours, $format = '%02d:%02d:%02d'): string
    {
        $total_minutes = $total_hours * 60;
        if ($total_minutes < 0.0 || ! $total_minutes) {
            return '00:00:00';
        }

        $hours = floor($total_minutes / 60);
        $minutes = ($total_minutes % 60);
        $seconds = ($total_minutes * 60) % 60;

        return sprintf($format, $hours, $minutes, $seconds);
    }
}



if (!function_exists('logo_url')) {
    function logo_url(): string
    {
        return Storage::disk(config('app.disk'))
            ->url('logo/logo.png');
    }
}

if (!function_exists('favicon_url')) {
    function favicon_url(): string
    {
        return Storage::disk(config('app.disk'))
            ->url('logo/favicon.png');
    }
}


if (!function_exists('client_url')) {
    function client_url($value): string
    {
        return URL::format(config('app.client_url'), $value);
    }
}


if (!function_exists('getBrowserName')) {
    function getBrowserName(string $userAgent): string
    {
        if (stripos($userAgent, 'Edge') !== false) return 'Edge';
        if (stripos($userAgent, 'OPR') !== false || stripos($userAgent, 'Opera') !== false) return 'Opera';
        if (stripos($userAgent, 'Chrome') !== false) return 'Chrome';
        if (stripos($userAgent, 'Safari') !== false) return 'Safari';
        if (stripos($userAgent, 'Firefox') !== false) return 'Firefox';
        if (stripos($userAgent, 'MSIE') !== false || stripos($userAgent, 'Trident') !== false) return 'Internet Explorer';

        return 'Unknown';
    }
}
