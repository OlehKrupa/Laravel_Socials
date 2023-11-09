<?php

use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('auth/redirect', function() {
    return Socialite::driver('google')->redirect();
});
Route::get('auth/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::middleware(['auth:sanctum', 'verified'])->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
