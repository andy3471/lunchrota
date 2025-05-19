<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('demo', [HomeController::class, 'demo'])->name('demo-mode');

Route::middleware('auth')->group(function () {
    Route::post('change-password', [UserController::class, 'changePassword'])->name('password.change')->middleware('demo_mode');
});

// Disable Register Route if Registration Disabled
if (config('app.register_enabled')) {
    Auth::routes();
} else {
    Auth::routes(['register' => false]);
}
