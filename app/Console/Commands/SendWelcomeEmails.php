<?php

namespace App\Console\Commands;

use App\Jobs\SendWelcomeEmail;
use App\Models\User;
use Illuminate\Console\Command;

class SendWelcomeEmails extends Command
{
    protected $signature = 'email:send-welcome';
    protected $description = 'Send welcome emails';

    public function handle()
    {
        $users = User::subscribed()
            ->createdWithinLast5Days()
            ->get();

        foreach ($users as $user) {
            SendWelcomeEmail::dispatch($user);
        }

        $this->info('Welcome emails sent successfully!');
    }
}
