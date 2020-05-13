<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('app');
});


Route::group(['prefix' => 'home/', 'namespace' => 'Admin'], function(){

    Route::resource('schedule','ScheduleResourceController')
    ->names('schedule');

    Route::resource('calendar','CalendarResourceController')
    ->names('calendar');

    Route::resource('client','ClientResourceController')
    ->names('client');

    Route::resource('record','RecordResourceController')
    ->names('record');
    Route::get('record/gethour/{day}/{group}','RecordResourceController@getHour');

    Route::resource('place', 'PlaceResourceController')->names('place');

});

Route::group(['namespace' => 'Api', 'prefix' => 'api'], function(){
    Route::resource('record','RecordController')->names('api.record');
});
