<?php

namespace App\Channels;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\ConnectionException;

class SmsChannel
{
    /**
     * @throws ConnectionException
     */
    public function send($notifiable, $notification)
    {
        if (!method_exists($notification, 'toSms')) return;

        $phone = $notifiable->routeNotificationFor('sms');
        $message = $notification->toSms($notifiable);

        if (empty($phone) || empty($message)) return;

        if (! config('app.sms.enabled')) {
            Log::info('SMS sending is disabled in configuration.');
            return 'SMS sending is disabled in configuration.';
        }

        $response = Http::baseUrl(config('app.sms.base_url'))
            ->timeout(15)
            ->post('/api/smsapi', [
                'api_key'  => config('app.sms.api_key'),
                'senderid' => config('app.sms.sender_id'),
                'type'     => config('app.sms.type'),
                'number'   => $phone,
                'message'  => $message,
            ]);


        if (! $response->successful()) {
            Log::error('SMS send failed', [
                'number'   => $phone,
                'message'  => $message,
                'response' => $response->body(),
            ]);

            return;
        }

        Log::info('SMS sent successfully', [
            'number'   => $phone,
            'message'  => $message,
            'response' => $response->body(),
        ]);
    }
}
