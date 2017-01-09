<?php

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
    return view('welcome');
});

Route::get('login', [
    'as' => 'get.login',
    'uses' => 'AuthController@getLogin',
]);

Route::post('login', [
    'as' => 'post.login',
    'uses' => 'AuthController@postLogin',
]);

Route::get('/home', [
    'uses' => 'HomeController@index',
    'as' => 'home',
]);

Route::get('test', function () {
    dd(session()->all());
});

Route::get('register', [
    'as' => 'get.register',
    'uses' => 'AuthController@getRegister',
]);

Route::post('register', [
    'as' => 'post.register',
    'uses' => 'AuthController@postRegister',
]);

Route::get('logout', [
    'as' => 'get.logout',
    'uses' => 'AuthController@getLogout',
]);

Route::get('user-all', [
    'as' => 'user.all',
    'uses' => 'AuthController@postRegister',
]);
