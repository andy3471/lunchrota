<?php

Route::get('/', 'HomeController@index')->name('home');
Route::get('about', 'HomeController@about')->name('about');
Route::get('roles', 'RoleController@index');

Route::get('/demo', 'HomeController@demo')->name('demomode');

Route::get('lunchslots', 'LunchSlotController@getSlots');
Route::get('lunchslots/users', 'LunchSlotController@userLunches');

Route::middleware('auth')->group(function () {
    Route::post('changepassword', 'UserController@changePassword')->name('changepassword')->middleware('demo_mode');
    Route::post('lunchslots/claim', 'LunchSlotController@claim');
    Route::post('lunchslots/unclaim', 'LunchSlotController@unclaim');
});

Route::middleware('can:admin')->group(function () {
    Route::get('admin/roles', 'Admin\RoleController@roleAdmin')->name('roleadmin');
    Route::post('admin/roles', 'Admin\RoleController@adminUpdateRoleRequest');
    Route::get('admin/roles/get', 'Admin\RoleController@roleAdminGetRoles');

    Route::get('admin/upload', 'Admin\RoleController@userRolesUpload')->name('upload');
    Route::get('admin/upload/downloadcsv', 'Admin\RoleController@downloadCsv')->name('downloadcsv');
    Route::Post('admin/upload/uploadcsv', 'Admin\RoleController@importCsvRoles')->name('uploadcsv');

    Route::get('admin/userroles', 'Admin\RoleController@userRolesAdmin')->name('userrolesadmin');
    Route::get('admin/userroles/get', 'Admin\RoleController@get');
    Route::post('admin/userroles/post', 'Admin\RoleController@post');

    Route::get('admin/users', 'Admin\UserController@adminUsers')->name('usersadmin')->middleware('demo_mode');
    Route::post('admin/users', 'Admin\UserController@adminUsersPost')->middleware('demo_mode');
    Route::get('admin/users/get', 'Admin\UserController@adminUsersGet')->middleware('demo_mode');
    Route::post('admin/users/store', 'Admin\UserController@store')->name('storeuser');

    Route::get('admin/lunches', 'Admin\LunchSlotController@index')->name('lunchadmin');
    Route::get('admin/lunches/get', 'Admin\LunchSlotController@getAdminSlots');
    Route::post('admin/lunches', 'Admin\LunchSlotController@adminUpdateLunchSlots');

    Route::get('admin/appdel', 'Admin\AppDelSupportDayController@appDelAdmin')->name('appdeladmin');
    Route::get('admin/appdel/get', 'Admin\AppDelSupportDayController@get');
    Route::post('admin/appdel/post', 'Admin\AppDelSupportDayController@post');
});

//Disable Register Route if Registration Disabled
if (config('app.register_enabled')) {
    Auth::routes();
} else {
    Auth::routes(['register' => false]);
}
