<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('about', 'HomeController@about')->name('about');
Route::get('roles', 'RoleController@index');

Route::get('demo', 'HomeController@demo')->name('demomode');

Route::get('lunchslots', 'LunchSlotController@getSlots');
Route::get('lunchslots/users', 'LunchSlotController@userLunches');

Route::middleware('auth')->group(function () {
    Route::get('changepassword', 'UserController@changePassword')->name('changepassword')->middleware('demo_mode');
    Route::post('changepassword', 'UserController@updatePassword')->name('update.change_password')->middleware('demo_mode');
    Route::post('lunchslots/claim', 'LunchSlotController@claim');
    Route::post('lunchslots/unclaim', 'LunchSlotController@unclaim');
});

Route::prefix('admin')->middleware('can:admin')->group(function () {
    Route::get('roles', 'Admin\RoleController@roleAdmin')->name('admin.roles');
    Route::post('roles', 'Admin\RoleController@adminUpdateRoleRequest');
    Route::get('roles/get', 'Admin\RoleController@roleAdminGetRoles');

    Route::get('upload', 'Admin\RoleController@userRolesUpload')->name('admin.upload');
    Route::get('upload/downloadcsv', 'Admin\RoleController@downloadCsv')->name('admin.download_csv');
    Route::Post('upload/uploadcsv', 'Admin\RoleController@importCsvRoles')->name('uploadcsv');

    Route::get('userroles', 'Admin\RoleController@userRolesAdmin')->name('admin.user_roles');
    Route::get('userroles/get', 'Admin\RoleController@get');
    Route::post('userroles/post', 'Admin\RoleController@post');

    Route::get('users', 'Admin\UserController@adminUsers')->name('admin.users')->middleware('demo_mode');
    Route::post('users', 'Admin\UserController@adminUsersPost')->middleware('demo_mode');
    Route::get('users/get', 'Admin\UserController@adminUsersGet')->middleware('demo_mode');
    Route::post('users/store', 'Admin\UserController@store')->name('admin.users.store');

    Route::get('lunches', 'Admin\LunchSlotController@index')->name('admin.lunch_slots');
    Route::get('lunches/get', 'Admin\LunchSlotController@getAdminSlots');
    Route::post('lunches', 'Admin\LunchSlotController@adminUpdateLunchSlots');

    Route::get('appdel', 'Admin\AppDelSupportDayController@appDelAdmin')->name('admin.app_del');
    Route::get('appdel/get', 'Admin\AppDelSupportDayController@get');
    Route::post('appdel/post', 'Admin\AppDelSupportDayController@post');
});

//Disable Register Route if Registration Disabled
if (config('app.register_enabled')) {
    Auth::routes();
} else {
    Auth::routes(['register' => false]);
}
