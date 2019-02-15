<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::group(['middleware' => ['web']], function () {
    Route::resource('hotel', 'HotelController');
    Route::post('hotel/{id}','HotelController@update');
    Route::get('/', function() {
        return view('index');
    });
    Route::get('amenities','HotelController@getAmenities');
    Route::get('delete-image/{id}','HotelController@deleteImage');
});