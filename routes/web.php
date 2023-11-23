<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\SocialShareButtonsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', fn() => view('welcome'))->name('welcome');

Auth::routes();

// Social Auth Routes
Route::prefix('auth/{provider}')->group(function () {
    Route::get('/redirect', [SocialController::class, 'redirectToProvider']);
    Route::get('/callback', [SocialController::class, 'handleProviderCallback']);
});

// Social Media Share Routes
Route::get('/social-media-share', [SocialShareButtonsController::class, 'ShareCurrentPageWidget']);
Route::get('/social-media-share/{newsId}', [SocialShareButtonsController::class, 'ShareWidget'])->name('social.share');

// News Routes
Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('news.index');
    Route::get('/{id}', [NewsController::class, 'show'])->name('news.show');
});

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/toggle-subscription', [UserController::class, 'toggleSubscription'])->name('toggle-subscription');
    Route::get('/user/send-test-message', [UserController::class, 'sendTestMessage'])->name('user.send-test-message');

    // News Routes under auth protection
    Route::prefix('news')->group(function () {
        Route::get('/create', [NewsController::class, 'create'])->name('news.create');
        Route::post('/store', [NewsController::class, 'store'])->name('news.store');
    });
});

// Home Route
Route::middleware(['auth:sanctum', 'verified'])->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
