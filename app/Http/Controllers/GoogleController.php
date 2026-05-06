<?php

namespace App\Http\Controllers;

use Google\Client;
use Google\Service\Calendar;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirect()
    {
        $client = new Client();

        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));

        $client->setScopes([
            Calendar::CALENDAR,
        ]);

        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return response()->json($client->createAuthUrl());

        // return redirect()->away($client->createAuthUrl());
    }

    public function callback(Request $request)
    {
        $client = new Client();

        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));

        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['error'])) {
            return response()->json(['error' => 'Google auth failed'], 400);
        }

        $user = $request->user();

        $user->update([
            'google_token' => [
                'access_token'  => $token['access_token'],
                'refresh_token' => $token['refresh_token'] ?? null,
                'expires_in'    => $token['expires_in'],
                'created'       => time(),
            ],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Google connected successfully',
        ]);
    }
}
