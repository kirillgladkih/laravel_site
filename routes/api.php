<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



Route::group(['namespace' => 'Api', 'prefix' => ''], function(){
   
    Route::get('search/{phone}', 'ApiController@search');

    Route::post('reg', 'ApiController@reg');

    Route::post('record', 'ApiController@record');

    Route::get('getdays/{group}', 'ApiController@getdays');

    Route::get('gethours/{group}/{day}', 'ApiController@gethours');

    Route::group(['namespace' => 'Social' ,'prefix' => 'social'], function(){
        Route::get('{client}/{id}', 'ApiSocialController@getSocial');
        Route::post('', 'ApiSocialController@setSocial');
    });   
});

