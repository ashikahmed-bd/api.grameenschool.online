<?php

namespace App\Jobs;

use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue
{
    use Queueable;

    protected $number;
    protected $message;

    /**
     * Create a new job instance.
     */
    public function __construct($number, $message)
    {
        $this->number = $number;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): string
    {

        if (! config('app.sms.enabled')) {
            Log::info('SMS sending is disabled in configuration.');
            return 'SMS sending is disabled.';
        }

        $response = Http::baseUrl(config('app.sms.base_url'))
            ->post('/api/smsapi', [
                'api_key'  => config('app.sms.api_key'),
                'senderid' => config('app.sms.sender_id'),
                'type'     => config('app.sms.type'),
                'number'   => $this->number,
                'message'  => $this->message,
            ]);

        if (! $response->successful()) {
            Log::error('Failed to send SMS', [
                'number'   => $this->number,
                'message'  => $this->message,
                'response' => $response->body(),
            ]);

            return 'Failed to send SMS. Error: ' . $response->body();
        }

        Log::info('SMS sent successfully', [
            'number'   => $this->number,
            'message'  => $this->message,
            'response' => $response->body(),
        ]);

        return 'SMS sent successfully: ' . $response->body();
    }

    public function failed(\Throwable $exception): void
    {
        Log::critical('SMS Job permanently failed', [
            'number'  => $this->number,
            'message' => $this->message,
            'error'   => $exception->getMessage(),
        ]);
    }
}
