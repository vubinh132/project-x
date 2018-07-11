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
    Route::get('admin/products/test', 'Admin\\ProductsController@test');
    Route::resource('admin/products', 'Admin\\ProductsController');

    //Product checking
    Route::get('admin/product-checking', 'Admin\\ProductsController@productChecking');
    Route::get('admin/product-checking/test', 'Admin\\ProductsController@productCheckingTest');

    //get unit price of product
    Route::get('admin/products/{id}/unit-price', 'Admin\\ProductsController@getUnitPrice');

    //Orders
    Route::resource('admin/orders', 'Admin\\OrdersController');

    //ROM
    Route::resource('admin/rom', 'Admin\\ROMController');
    Route::get('admin/rom/change-return-status/{id}', 'Admin\\ROMController@changeReturnStatus');

    //Log
    Route::resource('admin/logs', 'Admin\\LogsController');
    Route::get('admin/list/logs', 'Admin\\LogsController@list');

    //General Settings
    //send email for testing
    Route::get('admin/general-settings/send-email', 'Admin\\GeneralSettingsController@sendEmail');
    //update sync day
    Route::get('admin/general-settings/update-syn-time', 'Admin\\GeneralSettingsController@updateSyncTime');
    Route::resource('admin/general-settings', 'Admin\\GeneralSettingsController');

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


});



