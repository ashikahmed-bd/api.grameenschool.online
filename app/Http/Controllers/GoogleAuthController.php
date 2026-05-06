<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Calendar;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    public function redirect(Request $request)
    {
        $client = new Client();

        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_url'));
        $client->setAccessType('offline');
        $client->setPrompt('consent');
        $client->setScopes([
            Calendar::CALENDAR,
        ]);

        return response()->json([
            'auth_url' => $client->createAuthUrl()
        ]);
    }

    public function callback(Request $request)
    {
        $client = new Client();

        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect_url'));
        $client->setScopes([
            Calendar::CALENDAR,
        ]);

        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['error'])) {
            return response()->json([
                'message' => 'Google authentication failed',
                'error' => $token
            ], 400);
        }

        $request->user()->update([
            'google_token' => $token
        ]);

        return response()->json([
            'message' => 'Google account connected successfully'
        ]);
    }
}
