<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'show'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

// Auth routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Subscription
    Route::get('/subscribe', [SubscriptionController::class, 'show'])->name('subscription.show');
    Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscription.store');

    // Protected by subscription
    Route::middleware('subscription')->group(function () {
        Route::get('/home/{page?}', [HomeController::class, 'index'])->name('home.index');
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
    });
});
