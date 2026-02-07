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
use App\Http\Controllers\Api\RoleController as ApiRoleController;

Route::get('roles', [ApiRoleController::class, 'index']);

Route::prefix('admin')->middleware('can:admin')->name('admin.')->group(function (): void {
    Route::get('user-roles', [RoleController::class, 'index'])->name('user-roles.index');
    Route::post('user-roles', [RoleController::class, 'update'])->name('user-roles.update');
});
