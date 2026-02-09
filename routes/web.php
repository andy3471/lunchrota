<?php

declare(strict_types=1);

use App\Http\Controllers\BrochureController;
use App\Http\Controllers\Team\RegistrationController;
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

Route::get('/', BrochureController::class)->name('brochure.home');

Route::get('/register', [RegistrationController::class, 'create'])->name('teams.register');
Route::post('/register', [RegistrationController::class, 'store'])->name('teams.store');
