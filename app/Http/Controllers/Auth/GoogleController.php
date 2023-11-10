<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            // Проверьте, существует ли пользователь с таким email
            $existingUser = User::where('email', $user->email)->first();

            if ($existingUser) {
                // Если пользователь существует, обновите google_id (если он изменился)
                $existingUser->google_id = $user->id;
                $existingUser->save();

                // Аутентифицируйте пользователя с помощью встроенной аутентификации Laravel
                Auth::login($existingUser);
            } else {
                // Создайте нового пользователя, если такого email нет
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'google_id' => $user->id,
                    'password' => '12345678',
                ]);
                // Аутентифицируйте нового пользователя
                Auth::login($newUser);
            }

        } catch (Exception $e) {
            dd($e);
            return redirect()->route('login')->with('error', 'Произошла ошибка при аутентификации.');
        }
        return redirect()->to('/home'); // Редирект на нужную страницу после аутентификации
    }

}
