<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'api/v1', 'middleware' => 'cors'], function() {
    Route::get('/product/list', 'ProductController@getList');
    Route::get('/object/{id}', 'ProductController@getObjectDetail');
    Route::put('/object/{id}', 'ProductController@updateObject');
    Route::post('/file/upload', 'PublicController@upload');
});


Route::group(['middleware' => 'cors'], function() {
    Route::post('/file/upload', 'PublicController@upload');
});
