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

Route::group(['prefix' => '/user', 'middleware' => ['auth']], function () {

    Route::get('/home', 'UserController@home');
    Route::get('/inn', 'UserController@inn');
    Route::get('/trip', 'UserController@trip');

});

Route::group(['prefix' => '/file'], function () {

    Route::post('/images', 'FileController@image');
    Route::get('/upload', 'FileController@upload');

});

Route::group(['prefix' => '/weixin'], function () {

    Route::match(['get', 'post'], '/message', 'WeixinController@message');

    Route::get('/createMenu', 'WeixinController@createMenu');

});

Route::get('/auth/login/weixin', 'Auth\AuthController@weixinLogin');
Route::get('/auth/login/weixinCallback', 'Auth\AuthController@weixinLoginCallback');
