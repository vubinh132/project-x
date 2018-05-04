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

Route::group(['middleware' => ['apiheader']], function () {
    Route::get('get-product/{id}', 'APIs\\ProductsController@getProduct');
    Route::post('get-products', 'APIs\\ProductsController@getProducts');
    Route::resource('orders', 'APIs\\OrdersController');
});

