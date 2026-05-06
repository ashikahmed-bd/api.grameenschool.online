<?php

namespace App\Notifications;

use App\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class CreateCourseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $course;

    /**
     * Create a new notification instance.
     */
    public function __construct($course)
    {
        $this->course = $course;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // return ['mail', 'database', 'broadcast'];
        return ['broadcast', SmsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Course Created: ' . $this->course->title)
            ->view('emails.create_course', [
                'user'   => $notifiable,
                'course' => $this->course,
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title'       => $this->course->title,
            'message'     => "A new course '{$this->course->title}' has been created by " . ($this->course->author->name ?? 'Admin') . ".",
            'created_at'  => $this->course->created_at->toDateTimeString(),
            'url'         => client_url('/course/' . $this->course->slug),
        ];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toSms(object $notifiable): string
    {
        return "Dear, {$notifiable->name}, A new course '{$this->course->title}' has been created by " . ($this->course->author->name ?? 'Admin') . ".";
    }

    /**
     * Broadcast payload (Realtime via Reverb/Pusher)
     */
    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title'       => $this->course->title,
            'message'     => "A new course '{$this->course->title}' has been created by " . ($this->course->author->name ?? 'Admin') . ".",
            'created_at'  => $this->course->created_at->toDateTimeString(),
            'url'         => client_url('/course/' . $this->course->slug),
        ]);
    }


    public function broadcastOn()
    {
        return new PrivateChannel('users.' . $this->course->user_id);
    }

    /**
     * Set broadcast event name for client listeners
     */
    public function broadcastAs(): string
    {
        return 'course.created';
    }
}
