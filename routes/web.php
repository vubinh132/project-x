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
    Route::resource('products', 'ProductsController');

    //volume Adjustment
    Route::get('volume-adjustment', 'ProductsController@getAdjustment');
    Route::post('volume-adjustment', 'ProductsController@postAdjustment');

    //product checking
    Route::get('product-checking', 'ProductsController@productChecking');

    //get unit price of product
    Route::get('products/{id}/unit-price', 'ProductsController@getUnitPrice');

    //quantity checking
    Route::post('quantity-checking/{id}', 'ProductsController@checkQuantity');

    //Orders
    Route::post('orders/get-orders', 'OrdersController@getOrders');
    Route::resource('orders', 'OrdersController');

    //ROM
//    Route::get('rom/commit', 'ROMController@commit');
//    Route::get('rom/change-return-status/{id}', 'ROMController@changeReturnStatus');
//    Route::resource('rom', 'ROMController');

    Route::get('rom', 'ROMController@getView');

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
    //update api key
    Route::post('general-settings/change-api-key', 'GeneralSettingsController@changeAPIKey');

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

    //Internal APIs
    Route::get('internal-apis', 'InternalApisController@index');
    Route::post('internal-apis/switch-lock/{id}', 'InternalApisController@switchLock');
});






