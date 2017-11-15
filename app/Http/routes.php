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
        'as'   => 'user.delete',
        'uses' => 'UserController@destroy'
    ]);
    Route::post('detail', [
        'as'   => 'user.get',
        'uses' => 'UserController@get'
    ]);
    Route::post('login', [
        'as'   => 'login',
        'uses' => 'UserController@login'
    ]);
    Route::get('list', [
        'as'         => 'user.list',
        'uses'       => 'UserController@index',
        'middleware' => 'auth'
    ]);
    Route::post('store', [
        'as' => 'user.store', 'uses' => 'UserController@store'
    ]);
    Route::post('update', [
        'as' => 'user.update', 'uses' => 'UserController@update'
    ]);
});

Route::group(['prefix' => 'category'], function () {
    Route::post('delete', [
        'as'   => 'category.delete',
        'uses' => 'CategoryController@destroy'
    ]);
    Route::get('list', [
        'as'         => 'category.list',
        'uses'       => 'CategoryController@index',
        'middleware' => 'auth'
    ]);
    Route::post('store', [
        'as' => 'category.store', 'uses' => 'CategoryController@store'
    ]);
});
