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
    Route::post('admin/products/{id}/change-image', 'Admin\\ProductsController@changeImage');
    Route::post('admin/products/{id}/delete', 'Admin\\ProductsController@destroy');
    Route::get('admin/products/test', 'Admin\\ProductsController@test');
    Route::resource('admin/products', 'Admin\\ProductsController');

    //Volume Adjustment
    Route::get('admin/volume-adjustment', 'Admin\\ProductsController@getAdjustment');
    Route::post('admin/volume-adjustment', 'Admin\\ProductsController@postAdjustment');
    //Product checking

    Route::get('admin/product-checking/test', 'Admin\\ProductsController@productCheckingTest');
    Route::get('admin/product-checking', 'Admin\\ProductsController@productChecking');

    //get unit price of product
    Route::get('admin/products/{id}/unit-price', 'Admin\\ProductsController@getUnitPrice');

    //Orders
    Route::resource('admin/orders', 'Admin\\OrdersController');

    //ROM
    Route::get('admin/rom/commit', 'Admin\\ROMController@commit');
    Route::get('admin/rom/change-return-status/{id}', 'Admin\\ROMController@changeReturnStatus');
    Route::resource('admin/rom', 'Admin\\ROMController');


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
    Route::resource('admin/notes', 'Admin\\NotesController');

    //External APIs
    //Lazada APIs
    //sync orders
    Route::get('admin/external-api/lazada/sync-all-orders', 'Admin\\external_apis\\LazadaController@syncAllOrders');
    Route::get('admin/external-api/lazada/sync-orders', 'Admin\\external_apis\\LazadaController@syncOrders');
    Route::get('admin/external-api/lazada/auth', 'Admin\\external_apis\\LazadaController@auth');
    Route::get('admin/external-api/lazada', 'Admin\\external_apis\\LazadaController@index');

    //Google APIs
    Route::get('admin/external-api/google', 'Admin\\external_apis\\GoogleController@index');

    //Finance
    Route::get('finance/import', 'FinanceController@import');
    Route::get('finance/import/{providerId}', 'FinanceController@importDetail');
    Route::get('finance/export', 'FinanceController@export');


});




