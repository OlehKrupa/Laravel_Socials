<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
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

            // Проверьте, существует ли пользователь с таким email
            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                $existingUser->{$provider . '_id'} = $user->id;
                $existingUser->save();

                Auth::login($existingUser);
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    $provider . '_id' => $user->id,
//                    'password' => '12345678',
                ]);

                Auth::login($newUser);
            }
        } catch (Exception $e) {
            dd($e);
            return redirect()->route('login')->with('error', 'Произошла ошибка при аутентификации.');
        }

        return redirect()->to('/home');
    }
}
