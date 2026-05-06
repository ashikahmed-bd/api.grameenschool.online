<?php

namespace App\Services;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class ZoomService
{
    protected function accessToken()
    {
        $response = Http::asForm()
            ->withBasicAuth(
                config('services.zoom.client_id'),
                config('services.zoom.client_secret')
            )
            ->post('https://zoom.us/oauth/token', [
                'grant_type' => 'account_credentials',
                'account_id' => config('services.zoom.account_id'),
            ]);

        return $response->json()['access_token'];
    }

    public function createMeeting(array $data)
    {
        $token = $this->accessToken();

        return Http::withToken($token)->post(
            'https://api.zoom.us/v2/users/me/meetings',
            [
                'topic' => $data['topic'],
                'type' => 2,
                'start_time' => Carbon::parse($data['start_time'])->toIso8601String() ?? Carbon::now()->addMinutes(5)->toIso8601String(),
                'duration' => 120,
                'timezone' => config('app.timezone'),
                'settings' => [
                    'join_before_host' => true,
                    'waiting_room' => false,
                ],
            ]
        )->json();
    }
}
