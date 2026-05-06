<?php

namespace App\Services;

use Exception;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;

class GoogleMeetService
{
    public Client $client;
    protected Calendar $calendar;

    /**
     * Constructor
     *
     * @param array $accessToken User Google OAuth token (from DB)
     */
    /**
     * @param array $token Google OAuth token from DB
     */
    public function __construct(array $token)
    {
        if (empty($token)) {
            throw new Exception('Google token missing. Re-auth required.');
        }
        $this->client = new Client();

        $this->client->setApplicationName(config('app.name'));
        $this->client->setClientId(config('services.google.client_id'));
        $this->client->setClientSecret(config('services.google.client_secret'));

        $this->client->setScopes([
            Calendar::CALENDAR,
        ]);

        $this->client->setAccessType('offline');
        $this->client->setAccessToken($token);

        // Auto refresh
        if ($this->client->isAccessTokenExpired()) {

            if (empty($token['refresh_token'])) {
                throw new Exception('Google refresh token missing. Reconnect Google.');
            }

            $newToken = $this->client->fetchAccessTokenWithRefreshToken(
                $token['refresh_token']
            );

            if (isset($newToken['error'])) {
                throw new Exception('Google token refresh failed');
            }
        }

        $this->calendar = new Calendar($this->client);
    }

    /**
     * Return updated token (after refresh)
     */
    public function getToken(): array
    {
        return $this->client->getAccessToken();
    }

    /**
     * Create a Google Calendar event with Google Meet link
     *
     * @param array $data ['topic', 'start_time', 'end_time']
     * @return array Event details with join_url
     */
    public function createMeeting(array $data): array
    {
        $event = new Event([
            'summary' => $data['topic'],
            'start' => [
                'dateTime' => $data['start_time'],
                'timeZone' => 'Asia/Dhaka',
            ],
            'end' => [
                'dateTime' => $data['end_time'],
                'timeZone' => 'Asia/Dhaka',
            ],
            'conferenceData' => [
                'createRequest' => [
                    'requestId' => uniqid(), // Unique ID for meet
                ],
            ],
        ]);

        // Insert event into primary calendar
        $event = $this->calendar->events->insert(
            'primary',
            $event,
            ['conferenceDataVersion' => 1]
        );

        return [
            'event_id'  => $event->getId(),
            'join_url'  => $event->getHangoutLink(), // Google Meet link
            'html_link' => $event->getHtmlLink(),    // Calendar link
            'start'     => $event->getStart()->getDateTime(),
            'end'       => $event->getEnd()->getDateTime(),
            'summary'   => $event->getSummary(),
            'status'    => $event->getStatus(),
        ];
    }
}
