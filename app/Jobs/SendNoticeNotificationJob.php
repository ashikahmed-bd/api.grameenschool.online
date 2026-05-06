<?php

namespace App\Jobs;

use App\Models\Notice;
use App\Models\User;
use App\Notifications\NoticeNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNoticeNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Notice $notice;

    /**
     * Create a new job instance.
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('Dispatching notice notification for target role: ' . $this->notice->target);

        User::query()->where('role', $this->notice->target)
            ->chunk(1000, function ($users) {
                foreach ($users as $user) {
                    $user->notify(new NoticeNotification($this->notice));
                }
            });
    }
}
