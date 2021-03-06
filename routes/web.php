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

Route::group([
    'namespace' => 'Chat'
], function () {
    Route::get('/', 'ChatController@index');

    Route::group([
        'prefix' => 'chat'
    ], function () {
        Route::post('/send-message', 'ChatController@sendMessage');
        Route::get('/room/{room}', 'ChatController@getRoom')->middleware('auth');
    });
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
