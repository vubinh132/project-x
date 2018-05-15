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

Auth::routes();

Route::group(['middleware' => ['admin', 'revalidate']], function () {
    // Home page
    Route::get('admin', 'Admin\\AdminsController@index');

    //my profile without any permission
    Route::post('admin/users/{id}/change-profile-image', 'Admin\\UsersController@changeUserProfileImage');
    Route::get('admin/my-profile', 'Admin\\UsersController@myProfile');
    Route::get('admin/my-profile/edit', 'Admin\\UsersController@editMyProfile');
    Route::patch('admin/my-profile', 'Admin\\UsersController@updateProfile');
    Route::post('admin/change-profile-image', 'Admin\\UsersController@changeProfileImage');

    // Manage users, user profile
    Route::resource('admin/users', 'Admin\\UsersController', ['except' => ['destroy']]);

    //Roles
    Route::resource('admin/roles', 'Admin\\RolesController');

    //Diary
    Route::resource('admin/diary', 'Admin\\DiaryController');

    //Products
    Route::post('admin/products/{id}/change-image', 'Admin\\ProductsController@changeImage');
    Route::post('admin/products/{id}/delete', 'Admin\\ProductsController@destroy');
    Route::resource('admin/products', 'Admin\\ProductsController');


    //Orders
    Route::resource('admin/orders', 'Admin\\OrdersController');

    //Log
    Route::resource('admin/logs', 'Admin\\LogsController');
    Route::get('admin/list/logs', 'Admin\\LogsController@list');

    //General Settings
    Route::resource('admin/general-settings', 'Admin\\GeneralSettingsController');

    //Note
    Route::resource('admin/notes', 'Admin\\NotesController');

    // Settings
//    Route::resource('admin/settings/emails', 'Admin\\EmailController', ['except' => ['create', 'destroy']]);


});


