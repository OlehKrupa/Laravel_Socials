<?php

namespace App\Http\Controllers;

use App\Jobs\SendSubscriptionNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use SebastianBergmann\Environment\Console;

class UserController extends Controller
{
    public function toggleSubscription()
    {
        $user = Auth::user();

//        $user->is_subscribed = !$user->is_subscribed;

//        $user->save();

        SendSubscriptionNotification::dispatch($user);

        session()->flash('subscription_confirmation', 'Confirmation sent by email.');

        return redirect()->back();
    }

    public function Test()
    {
//        $apiKey = getenv('MAIL_PASSWORD');
//        $sg = new \SendGrid($apiKey);
    }
}
