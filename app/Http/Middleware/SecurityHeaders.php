<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Prevent clickjacking
        $response->headers->set('X-Frame-Options', 'DENY');

        // Prevent MIME-type sniffing
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // XSS Protection (Legacy but safe)
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Do not send referrer information
        $response->headers->set('Referrer-Policy', 'no-referrer');

        // Content Security Policy (basic, safe default)
        $response->headers->set(
            'Content-Security-Policy',
            "default-src 'self' https:; img-src 'self' data: https:; script-src 'self' https:; style-src 'self' https: 'unsafe-inline';"
        );

        // $response->headers->set('Content-Security-Policy', "default-src 'self' https:");

        // Enforce HTTPS for 1 year (HSTS)
        // Only enable this in production with valid SSL
        if (app()->environment('production')) {
            $response->headers->set(
                'Strict-Transport-Security',
                'max-age=31536000; includeSubDomains'
            );
        }

        return $response;
    }
}
