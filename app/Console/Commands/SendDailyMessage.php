<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendDailyMessage extends Command
{
    protected $signature = 'send:daily-message';
    protected $description = 'Send daily messages to users';

    public function handle()
    {
        $users = User::subscribed()
            ->createdWithinLast5Days()
            ->get();

        foreach ($users as $user) {
            $message = 'Message';

            Mail::raw($message, function ($mail) use ($user) {
                $mail->to($user->email)->subject('Daily');
            });

            $this->info("Daily message sent to {$user->email}");
        }
    }
}
