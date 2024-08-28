<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('demo', [HomeController::class, 'demo'])->name('demo-mode');

Route::middleware('auth')->group(function () {
    Route::post('change-password', [UserController::class, 'changePassword'])->name('password.change')->middleware('demo_mode');
});
//
//Route::prefix('admin')->middleware('can:admin')->name('admin.')->group(function () {
//    Route::get('user-roles/upload', [RoleController::class, 'upload'])->name('user-roles.upload');
//    Route::get('user-roles/upload/download-csv', [RoleController::class, 'download'])->name('user-roles.download');
//    Route::Post('user-roles/upload/upload-csv', [RoleController::class, 'import'])->name('user-roles.import');
//
//    Route::get('user-roles', [RoleController::class, 'index'])->name('user-roles.index');
//});

//Disable Register Route if Registration Disabled
if (config('app.register_enabled')) {
    Auth::routes();
} else {
    Auth::routes(['register' => false]);
}
