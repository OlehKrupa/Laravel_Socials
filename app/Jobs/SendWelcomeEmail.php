<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\WelcomeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWelcomeEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $daysSinceCreation = now()->diffInDays($this->user->created_at);

        // Define different titles and messages for the first 5 days
        $titles = [
            'Welcome to the Application',
            'Day 2 Greeting',
            'Day 3 Greeting',
            'Day 4 Greeting',
            'Day 5 Greeting',
        ];

        $messages = [
            'Welcome! We are excited to have you on board.',
            'Day 2 message.',
            'Day 3 message.',
            'Day 4 message.',
            'Day 5 message.',
        ];

        $link = url('https://uk.wikipedia.org/wiki/Патрон_(пес)');

        $this->user->notify(new WelcomeNotification($link, $messages[$daysSinceCreation], $titles[$daysSinceCreation]));
    }
}
