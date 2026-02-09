<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Lunch\ClaimController;
use App\Http\Controllers\User\PasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| These routes are loaded on tenant subdomains ({slug}.lunchrota.app).
| The ResolveTenantFromSubdomain middleware runs before these routes,
| making the current team available via app('currentTeam').
|
*/

// Home
Route::get('/', HomeController::class)->name('home');

// Guest routes
Route::middleware('guest')->group(function (): void {
    // Login
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);

    // Registration (guarded by team setting)
    Route::middleware('team.feature:register_enabled')->group(function (): void {
        Route::get('register', [RegisterController::class, 'create'])->name('register');
        Route::post('register', [RegisterController::class, 'store']);
    });

    // Password Reset (guarded by team setting)
    Route::middleware('team.feature:reset_password_enabled')->group(function (): void {
        Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
        Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
    });
});

// Authenticated routes
Route::middleware('auth')->group(function (): void {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('change-password', [PasswordController::class, 'show'])->name('password.change');
    Route::put('change-password', [PasswordController::class, 'update']);

    // Lunch slot actions
    Route::post('lunch-slots/claim', [ClaimController::class, 'store'])->name('lunch-slots.claim');
    Route::delete('lunch-slots/claim', [ClaimController::class, 'destroy'])->name('lunch-slots.unclaim');
});
