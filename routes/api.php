<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register','RegisterController@index');

Route::get('/getFloors','BookController@getFloor');

Route::get('/getRooms','BookController@getRooms');

Route::get('/getDates','BookController@getDates');

Route::get('/getDatesBySelect','BookController@getDatesBySelect');

Route::get('/getEquibments','BookController@getEquibments');

Route::post('/bookRoom','BookController@bookRoom');

Route::get('/getBookedRoom','BookController@getBookedRoom');

Route::get('/getAlluser','BookController@getAlluser');
