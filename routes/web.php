<?php

use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('auth/google',[GoogleController::class,'redirectToGoogle'])->name('google.page');
Route::get('auth/google/callback',[GoogleController::class,'handleGoogleCallback'])->name('google.redirect');
