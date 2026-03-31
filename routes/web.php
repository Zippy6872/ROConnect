<?php

use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::view('video-chat', 'video-chat')->name('video-chat');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::get('/chat', [ChatController::class, 'index']);
Route::post('/send-message', [ChatController::class, 'send']);

require __DIR__.'/settings.php';
