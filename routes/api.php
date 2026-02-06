<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\AdminApi\RoleController;
use App\Http\Controllers\Api\LunchSlotController;
use App\Http\Controllers\Api\RoleController as ApiRoleController;

Route::get('roles', [ApiRoleController::class, 'index']);

Route::get('lunch-slots', [LunchSlotController::class, 'getSlots'])->name('lunch-slots.index');
Route::get('lunch-slots/users', [LunchSlotController::class, 'userLunches'])->name('lunch-slots.users');

Route::middleware('auth')->group(function (): void {
    Route::post('lunch-slots/claim', [LunchSlotController::class, 'claim'])->name('lunch-slots.claim');
    Route::post('lunch-slots/un-claim', [LunchSlotController::class, 'unclaim'])->name('lunch-slots.un-claim');
});

Route::prefix('admin')->middleware('can:admin')->name('admin.')->group(function (): void {
    Route::get('user-roles', [RoleController::class, 'index'])->name('user-roles.index');
    Route::post('user-roles', [RoleController::class, 'update'])->name('user-roles.update');
});
