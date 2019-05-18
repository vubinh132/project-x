<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//API for mobile application
Route::group(['middleware' => ['api-middleware', 'jwt.auth']], function () {
    Route::get('general-information', 'APIs\\InformationController@getGeneralInformation');
    Route::get('get-product-data/{wildcard}', 'APIs\\InformationController@getProductData');
    Route::get('logs/{numberOfLogs}', 'APIs\\InformationController@getLogs');

    //products
    Route::post('products/check-quantity', 'APIs\\ProductsController@checkQuantity');

    //orders
    Route::post('orders/get-orders', 'APIs\\OrdersController@getOrders');

});

