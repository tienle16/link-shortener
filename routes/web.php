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

// Test commit branch in phpstorm

Route::post('/shorten', 'ShortenController@shorten')->name('clgt.abc');
Route::post('/shorten', 'ShortenController@shorten')->name('clgt.asss');
Route::post('/shorten', 'ShortenController@shorten')->name('clgt.aaaa');
