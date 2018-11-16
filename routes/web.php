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
Route::post('admin/product-checking/update-quantity', 'Admin\\ProductsController@updateQuantity');

Route::group(['middleware' => ['admin', 'revalidate']], function () {
    // Home page
    Route::get('/', 'AdminsController@index');

    //my profile without any permission
    Route::post('users/{id}/change-profile-image', 'UsersController@changeUserProfileImage');
    Route::get('my-profile', 'UsersController@myProfile');
    Route::get('my-profile/edit', 'UsersController@editMyProfile');
    Route::patch('my-profile', 'UsersController@updateProfile');
    Route::post('change-profile-image', 'UsersController@changeProfileImage');

    // Manage users, user profile
    Route::resource('users', 'UsersController', ['except' => ['destroy']]);

    //Roles
    Route::resource('roles', 'RolesController');

    //Diary
    Route::resource('diary', 'DiaryController');

    //Products
    Route::post('products/{id}/change-image', 'ProductsController@changeImage');
    Route::post('products/{id}/delete', 'ProductsController@destroy');
    Route::get('products/test', 'ProductsController@test');
    Route::resource('products', 'ProductsController');

    //Volume Adjustment
    Route::get('volume-adjustment', 'ProductsController@getAdjustment');
    Route::post('volume-adjustment', 'ProductsController@postAdjustment');
    //Product checking

    Route::get('admin/product-checking/test', 'Admin\\ProductsController@productCheckingTest');
    Route::get('admin/product-checking', 'Admin\\ProductsController@productChecking');

    //get unit price of product
    Route::get('admin/products/{id}/unit-price', 'Admin\\ProductsController@getUnitPrice');

    //Orders
    Route::resource('admin/orders', 'Admin\\OrdersController');

    //ROM
    Route::get('rom/commit', 'ROMController@commit');
    Route::get('rom/change-return-status/{id}', 'ROMController@changeReturnStatus');
    Route::resource('rom', 'ROMController');


    //Log
    Route::resource('logs', 'LogsController');
    Route::get('list/logs', 'LogsController@list');

    //General Settings
    //send email for testing
    Route::get('general-settings/send-email', 'GeneralSettingsController@sendEmail');
    //update sync day
    Route::get('general-settings/update-syn-time', 'GeneralSettingsController@updateSyncTime');
    //change password
    Route::post('general-settings/change-password', 'GeneralSettingsController@changePassword');

    Route::resource('general-settings', 'GeneralSettingsController');

    //Note
    Route::resource('notes', 'NotesController');

    //External APIs
    //Lazada APIs
    //sync orders
    Route::get('external-api/lazada/auth', 'external_apis\\LazadaController@auth');
    Route::get('external-api/lazada', 'external_apis\\LazadaController@index');

    //Google APIs
    Route::get('external-api/google', 'external_apis\\GoogleController@index');

    //Finance
    Route::get('finance/import', 'FinanceController@import');
    Route::get('finance/import/{providerId}', 'FinanceController@importDetail');
    Route::get('finance/export', 'FinanceController@export');


});




