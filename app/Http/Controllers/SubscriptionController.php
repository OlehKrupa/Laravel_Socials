<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function continueSubscription(User $user)
    {
        $user->update(['is_subscribed' => true]);
//        return redirect()->back();
    }

    public function cancelSubscription(User $user)
    {
        $user->update(['is_subscribed' => false]);
//        return redirect()->back();
    }
}
