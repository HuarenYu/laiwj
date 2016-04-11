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

Route::get('/', 'IndexController@index');

Route::get('/inns/{id}', 'InnController@detail');

Route::get('/inns/{id}/order', 'InnController@order');

Route::group(['prefix' => '/api'], function () {

    Route::resource('/inns', 'InnController');

    Route::resource('/orders', 'OrderController');

});

Route::group(['prefix' => '/user'], function () {

    Route::get('/inn', 'UserController@inn');

});
