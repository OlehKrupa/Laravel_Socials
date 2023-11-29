<?php

namespace App\Jobs;

use App\Models\User;
use App\Notifications\SendgridStatsNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendSendgridStatsNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $percent;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, $percent)
    {
        $this->user = $user;
        $this->percent = $percent;
    }

    public function handle()
    {
        $this->user->notify(new SendgridStatsNotification($this->percent));
    }

}
