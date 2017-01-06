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

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/mail', function () {
    return view('mail');
});

Route::get('update-post/{post}', function (App\Post $post) {
    if (Gate::allows('update', $post)) {
        echo 'allows';
    } else {
        echo 'not allows';
    }
    if (Gate::denies('update', $post)) {
        echo 'denies';
    } else {
        echo 'not denies';
    }
    echo Auth::user()->can('update', $post)?'can':'can\'t';
});

Route::post('send-mail', ['uses' => 'MailController@send', 'as' => 'send.mail']);
Auth::routes();

Route::get('/home', 'HomeController@index');
