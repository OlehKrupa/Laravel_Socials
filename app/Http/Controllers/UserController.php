<?php

namespace App\Http\Controllers;

use App\Jobs\SendSubscriptionNotification;
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

    public function sendTestMessage()
    {
        $user = Auth::user();
        $message = '123';

        Mail::raw($message, function ($mail) use ($user) {
            $mail->to($user->email)->subject('New mail');
        });
    }
}
