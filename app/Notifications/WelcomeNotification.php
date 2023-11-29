<?php

namespace App\Notifications;

use App\Models\NotificationClick;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WelcomeNotification extends Notification
{
    use Queueable;

    /**
     * The link for the notification action.
     *
     * @var string
     */
    private $link;

    /**
     * The message text for the notification.
     *
     * @var string
     */
    private $message;

    /**
     * The title for the notification.
     *
     * @var string
     */
    private $title;

    /**
     * Create a new notification instance.
     *
     * @param string $link
     * @param string $message
     * @param string $title
     */
    public function __construct(string $link, string $message, string $title)
    {
        $this->link = $link;
        $this->message = $message;
        $this->title = $title;
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
//        $utmParameters = [
//            'utm_source' => 'email',
//            'utm_medium' => 'notification',
//            'utm_campaign' => 'welcome_email',
//        ];
//
//        $trackedLink = $this->link . '?' . http_build_query($utmParameters);

        return (new MailMessage)
            ->line($this->message)
            ->greeting('Hello, ' . $notifiable->name)
            ->action('Partner link', $this->link)
            ->line('Thank you for using our application!')
            ->subject($this->title);
//            ->action('Stop Subscription', url("/cancel-subscription/{$notifiable->id}"));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            // Additional data for the notification array representation if needed
        ];
    }
}
