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

Route::group(['prefix' => 'article'], function () {
    Route::get('create', [
        'as'         => 'article.create',
        'uses'       => 'ArticleController@create',
        'middleware' => 'auth'
    ]);
    Route::post('delete', [
        'as'   => 'article.delete',
        'uses' => 'ArticleController@destroy'
    ]);
    Route::get('edit/{id}', [
        'as'         => 'article.edit',
        'uses'       => 'ArticleController@edit',
        'middleware' => 'auth'
    ]);
    Route::get('list', [
        'as'         => 'article.list',
        'uses'       => 'ArticleController@index',
        'middleware' => 'auth'
    ]);
    Route::post('store', [
        'as'         => 'article.store',
        'uses'       => 'ArticleController@store'
    ]);
    Route::post('update', [
        'as'         => 'article.update',
        'uses'       => 'ArticleController@update'
    ]);
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
    Route::get('logout', [
        'as'   => 'logout',
        'uses' => 'UserController@logout'
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
