<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('about', 'HomeController@about')->name('about');
Route::get('roles', 'RoleController@index');

Route::get('lunchslots', 'LunchSlotController@getSlots');
Route::get('lunchslots/users', 'LunchSlotController@userLunches');

Route::middleware('auth')->group(function () {
    Route::post('changepassword', 'UserController@changePassword')->name('changepassword');
    Route::post('lunchslots/claim', 'LunchSlotController@claim');
    Route::post('lunchslots/unclaim', 'LunchSlotController@unclaim');
});

Route::middleware('can:admin')->group(function () {
    Route::get('admin/userroles', 'RoleController@userRolesAdmin')->name('userrolesadmin');
    Route::get('admin/roles', 'RoleController@roleAdmin')->name('roleadmin');
    Route::post('admin/roles', 'RoleController@roleAdminUpdateRoles');
    Route::get('admin/roles/get', 'RoleController@roleAdminGetRoles');
    Route::get('admin/upload', 'RoleController@userRolesUpload')->name('upload');
    Route::get('admin/upload/downloadcsv', 'RoleController@downloadCsv')->name('downloadcsv');
    Route::Post('admin/upload/uploadcsv', 'RoleController@uploadCsv')->name('uploadcsv');
    Route::get('admin/users', 'UserController@adminUsers')->name('usersadmin');
    Route::get('admin/users/get', 'UserController@adminUsersGet');
    Route::get('admin/lunches', 'LunchSlotController@index')->name('lunchadmin');
    Route::get('admin/lunches/get', 'LunchSlotController@getAdminSlots');
    Route::post('admin/lunches', 'LunchSlotController@adminUpdateSlots');
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
