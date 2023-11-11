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

Route::get('/', 'MemberController@index')->name('index');
Route::get('/create', 'MemberController@create')->name('create');
Route::post('/store', 'MemberController@store')->name('store');
Route::get('/edit/{id}', 'MemberController@edit')->name('edit');
Route::post('/update', 'MemberController@update')->name('update');
Route::post('/delete', 'MemberController@destroy')->name('destroy');
