<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\LunchSlotController;
use App\Http\Controllers\Front\RoleController;
use App\Http\Controllers\Front\UserController;
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
Route::get('/', [HomeController::class, 'index'])->name('home');

// Guest routes
Route::middleware('guest')->group(function (): void {
    // Login
    Route::get('login', [LoginController::class, 'create'])->name('login');
    Route::post('login', [LoginController::class, 'store']);

    // Registration (conditional)
    if (config('app.register_enabled')) {
        Route::get('register', [RegisterController::class, 'create'])->name('register');
        Route::post('register', [RegisterController::class, 'store']);
    }

    // Password Reset
    if (config('app.reset_password_enabled')) {
        Route::get('forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
        Route::post('forgot-password', [ForgotPasswordController::class, 'store'])->name('password.email');
        Route::get('reset-password/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
        Route::post('reset-password', [ResetPasswordController::class, 'store'])->name('password.update');
    }
});

// Authenticated routes
Route::middleware('auth')->group(function (): void {
    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
    Route::get('change-password', [UserController::class, 'show'])->name('password.change');
    Route::post('change-password', [UserController::class, 'changePassword'])->middleware('demo_mode');

    // Lunch slot actions
    Route::post('lunch-slots/claim', [LunchSlotController::class, 'claim'])->name('lunch-slots.claim');
    Route::post('lunch-slots/unclaim', [LunchSlotController::class, 'unclaim'])->name('lunch-slots.unclaim');

    // Roles
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
});
