<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // X-APP-KEY validation (browser / web client only)
        if ($request->header('X-APP-KEY') !== config('app.app_key')) {
            abort(response()->json([
                'message' => 'Access denied. Request could not be verified.',
            ], 403));
        }

        return $next($request);
    }
}
