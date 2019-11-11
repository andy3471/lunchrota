<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/about', 'HomeController@about')->name('about');
Route::post('changepassword', 'UserController@changePassword')->name('changepassword');
Route::get('/roles', 'RoleController@index');



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


//TBR
Route::get('/dsp', 'HomeController@dsptest');
