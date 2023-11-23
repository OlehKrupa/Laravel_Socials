<?php

namespace App\Console\Commands;

use App\Mail\RandomPasswordMail;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class SendDailyMessage extends Command
{
    protected $signature = 'send:daily-message';
    protected $description = 'Send daily messages to users';

    public function handle()
    {
        $users = User::where('created_at', '<=', now()->subDays(5))
            ->where('is_subscribed', 1)
            ->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new RandomPasswordMail(12345));
        }
    }
}
