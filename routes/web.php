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

Route::get('/', 'ShortenController@index')->name('clgt');
Route::post('/shorten', 'ShortenController@shorten')->name('clgt.shorten');

Auth::routes();
Route::get('/test', function () {
    echo '12312313';
});