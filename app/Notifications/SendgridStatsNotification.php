<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendgridStatsNotification extends Notification
{
    use Queueable;

    private $percent;

    /**
     * Create a new notification instance.
     */
    public function __construct($percent)
    {
        $this->percent = $percent;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $notificationMessage = "Hello Admins!\n\n"
            . "I want to share some statistics about email campaigns:\n\n"
            . "The click-through rate from email campaigns is {$this->percent}%.\n\n"
            . "Best regards,\nYour Application";

        return (new MailMessage)
            ->line($notificationMessage);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
