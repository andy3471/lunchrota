<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('about', 'HomeController@about')->name('about');
Route::get('roles', 'RoleController@index');
Route::get('lunchslots', 'LunchSlotController@index');

Route::middleware('auth')->group(function () {
    Route::post('changepassword', 'UserController@changePassword')->name('changepassword');
    Route::post('lunchslots/store', 'LunchSlotController@store');
    Route::post('lunchslots/destroy', 'LunchSlotController@destroy');
});

Route::middleware('can:admin')->group(function () {
    Route::get('admin/roles', 'AdminController@roles')->name('rolesadmin');
    Route::get('admin/upload', 'AdminController@upload')->name('upload');
    Route::get('admin/users', 'AdminController@users')->name('usersadmin');
    Route::post('admin/users/store', 'UserController@store')->name('storeuser');
    Route::get('roles/get', 'RoleController@get');
    Route::post('roles/post', 'RoleController@post');
});

//Disable Register Route if Registration Disabled
if (config('app.register_enabled')) {
    Auth::routes();
} else {
    Auth::routes(['register' => false]);
}
