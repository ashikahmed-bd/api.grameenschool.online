<?php

namespace App\Listeners;

use App\Enums\UserRole;
use App\Events\NoticeCreatedEvent;
use App\Models\User;
use App\Notifications\NoticeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;

class SendNoticeToUsersListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NoticeCreatedEvent $event): void
    {
        $notice = $event->notice;

        $targets = $notice->course_id
            ? $notice->course->enrollments()->pluck('users.id')
            : User::query()->where('role', (UserRole::STUDENT)->value)->pluck('id');

        // Chunk the users in batches of 1,000 to avoid memory issues
        $targets->chunk(1000)->each(function (Collection $chunk) use ($notice) {
            User::query()->whereIn('id', $chunk)->get()
                ->each(fn ($user) => $user->notify(new NoticeNotification($notice)));
        });
    }
}
