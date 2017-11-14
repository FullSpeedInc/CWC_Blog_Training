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
    return view('user/login');
});

Route::group(['prefix' => 'user'], function () {
    Route::post('delete', [
        'as' => 'user.delete',
        'uses' => 'UserController@destroy'
    ]);
    Route::post('login', [
        'as' => 'login',
        'uses' => 'UserController@login'
    ]);
    Route::get('list', [
        'as' => 'user.list',
        'uses' => 'UserController@index',
        'middleware' => 'auth'
    ]);
    Route::post('store', [
        'as' => 'user.store', 'uses' => 'UserController@store'
    ]);
});
