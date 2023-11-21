<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RandomPasswordMail;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();

            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                $existingUser->{$provider . '_id'} = $user->id;
                $existingUser->save();

                Auth::login($existingUser);
            } else {
                $password = $this->str_random(12);

                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'password' => $password,
                    $provider . '_id' => $user->id,
                ]);

                Mail::to($newUser->email)->send(new RandomPasswordMail($password));

                Auth::login($newUser);
            }
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', $e);
        }

        return redirect()->to('/home');
    }

    private function str_random($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }
}
