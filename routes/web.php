<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/**
 * AUTH WEB ROUTES 
 * 
 */
Route::prefix('auth')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
        Route::get('password/reset', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
        Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetPasswordForm'])->name('password.reset.token');

        Route::post('register', [RegisterController::class, 'register'])->name('auth.register');
        Route::post('login', [LoginController::class, 'login'])->name('auth.login');
        Route::post('password/email', [PasswordResetController::class, 'reset'])->name('password.email');
        Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');
    });

    Route::middleware('auth:users')->group(function () {
        Route::get('email/verify', [EmailVerificationController::class, 'show'])->name('verification.notice');
        Route::get('email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
        
        Route::post('email/verification-notification', [EmailVerificationController::class, 'resend'])->name('verification.resend')->middleware('throttle:6,1');
        Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    });
});

/**
 * DASHBOARD WEB ROUTES
 * 
 */