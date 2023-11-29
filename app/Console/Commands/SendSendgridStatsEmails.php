<?php

namespace App\Console\Commands;

use App\Jobs\SendSendgridStatsNotification;
use App\Models\SendgridStatistic;
use App\Models\User;
use Illuminate\Console\Command;

class SendSendgridStatsEmails extends Command
{
    protected $signature = 'email:sendgrid-stats';
    protected $description = 'Command description';

    public function handle()
    {
        $users = User::admins()->get();

        $percent = $this->percent();

        foreach ($users as $user) {
            SendSendgridStatsNotification::dispatch($user, $percent);
        }

        $this->info('Stats notification sent successfully to admins.');
    }

    public function percent(): int
    {
        $statistics = SendgridStatistic::nonAdmin()->get();

        $emailPairs = [];

        foreach ($statistics as $statistic) {
            $email = $statistic->email;
            $event = $statistic->event;

            if (!isset($emailPairs[$email])) {
                $emailPairs[$email] = ['open' => 0, 'click' => 0];
            }

            if ($event === 'open') {
                $emailPairs[$email]['open']++;
            } elseif ($event === 'click') {
                $emailPairs[$email]['click']++;
            }
        }

        $totalOpens = 0;
        $totalClicks = 0;

        foreach ($emailPairs as $emailPair) {
            $totalOpens += $emailPair['open'];
            $totalClicks += $emailPair['click'];
        }

        return ($totalClicks / $totalOpens) * 100;
    }

}
