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


Route::get('', function(){
    return redirect('home/calendar');
});

Route::group(['prefix' => 'home/', 'namespace' => 'Admin\Auth', 'middleware' => 'guest:web'], function(){

    Route::get('login','AuthController@showLoginForm');

    Route::post('login', 'AuthController@login')
    ->name('login');

});

Route::group(['prefix' => 'home/', 'namespace' => 'Admin', 'middleware' => 'auth:web'], function(){

    Route::resource('schedule','ScheduleResourceController')
    ->names('schedule');

    Route::resource('calendar','CalendarResourceController')
    ->names('calendar');

    Route::resource('client','ClientResourceController')
    ->names('client');
    Route::post('client/child','ClientResourceController@storeChild');

    Route::resource('record','RecordResourceController')
    ->names('record');
    Route::get('record/gethour/{day}/{group}','RecordResourceController@getHour');

    Route::resource('closed','ClosedResourceController')
    ->names('closed');


    Route::resource('place', 'PlaceResourceController')->names('place');

    Route::get('logout', 'Auth\AuthController@logout')
    ->name('logout');

});



