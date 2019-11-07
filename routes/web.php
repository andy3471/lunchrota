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

//Admin - Needs Admin Middleware
Route::get('admin/roles', 'AdminController@roles')->name('rolesadmin');
Route::get('admin/upload', 'AdminController@upload')->name('upload');
Route::get('admin/users', 'AdminController@users')->name('usersadmin');

//Disable Register Route if Registration Disabled
if (config('app.login_enabled')) {
    Auth::routes();
} else {
    Auth::routes(['register' => false]);
}
