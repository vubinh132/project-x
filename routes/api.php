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
Route::group(['middleware' => ['api-middleware']], function () {
    Route::get('general-information', 'APIs\\InformationController@getGeneralInformation');
    Route::get('get-product-repository/{id}', 'APIs\\InformationController@getProductRepository');
    Route::get('logs/{numberOfLogs}', 'APIs\\InformationController@getLogs');
});

