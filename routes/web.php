<?php
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\SocialShareButtonsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

// Social Authentication Routes
Route::prefix('auth/{provider}')->group(function () {
    Route::get('/redirect', [SocialController::class, 'redirectToProvider']);
    Route::get('/callback', [SocialController::class, 'handleProviderCallback']);
});

// Social Media Share Routes
Route::prefix('social-media-share')->group(function () {
    Route::get('/', [SocialShareButtonsController::class, 'ShareCurrentPageWidget']);
    Route::get('/{newsId}', [SocialShareButtonsController::class, 'ShareWidget'])->name('social.share');
});

// News Routes
Route::prefix('news')->group(function () {
    Route::get('/', [NewsController::class, 'index'])->name('news.index');
    Route::get('/create', [NewsController::class, 'create'])->middleware('auth')->name('news.create');
    Route::post('/store', [NewsController::class, 'store'])->middleware('auth')->name('news.store');
    Route::get('/{id}', [NewsController::class, 'show'])->name('news.show');
});

// User Routes
Route::middleware(['auth'])->group(function () {
    Route::post('/toggle-subscription', [UserController::class, 'toggleSubscription'])->name('toggle-subscription');
    Route::get('/user/send-test-message', [UserController::class, 'sendTestMessage'])->name('user.send-test-message');
});

// Authenticated Home Route
Route::middleware(['auth:sanctum', 'verified'])->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
