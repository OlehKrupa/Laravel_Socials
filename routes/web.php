<?php

use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\SocialShareButtonsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

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

Route::get('auth/{provider}/redirect', [SocialController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialController::class, 'handleProviderCallback']);

Route::get('/social-media-share', [SocialShareButtonsController::class,'ShareWidget']);
Route::get('/social-media-share/{newsId}', [SocialShareButtonsController::class,'ShareWidget'])->name('social.share');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/create', [NewsController::class, 'create'])->name('news.create');
Route::post('/news/store', [NewsController::class, 'store'])->name('news.store');
Route::get('/news/{id}', [NewsController::class, 'show'])->name('news.show');



Route::middleware(['auth:sanctum', 'verified'])->get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
