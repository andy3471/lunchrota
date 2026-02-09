<?php

declare(strict_types=1);

use App\Http\Controllers\Front\BrochureController;
use App\Http\Controllers\Front\TeamRegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Brochure Routes (Main Domain)
|--------------------------------------------------------------------------
|
| These routes are loaded on the main domain (lunchrota.app).
| They serve the public-facing brochure site and team registration.
|
*/

Route::get('/', [BrochureController::class, 'index'])->name('brochure.home');

Route::get('/register', [TeamRegistrationController::class, 'create'])->name('teams.register');
Route::post('/register', [TeamRegistrationController::class, 'store'])->name('teams.store');
