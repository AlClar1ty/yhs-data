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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::group( ['middleware' => 'auth' ], function(){
	Route::get('/', 'MemberController@index')->name('index');
	Route::get('/create', 'MemberController@create')->name('create');
	Route::post('/store', 'MemberController@store')->name('store');
	Route::get('/edit/{id}', 'MemberController@edit')->name('edit');
	Route::post('/update', 'MemberController@update')->name('update');
	Route::post('/delete', 'MemberController@destroy')->name('destroy');

	//master pastor
	Route::group(['prefix' => 'pastor'], function () {
		Route::get('/', 'PastorController@index')->name('pastor_list');
		Route::get('/create', 'PastorController@create')->name('pastor_create');
		Route::post('/store', 'PastorController@store')->name('pastor_store');
		Route::get('/edit/{id}', 'PastorController@edit')->name('pastor_edit');
		Route::post('/update', 'PastorController@update')->name('pastor_update');
		Route::post('/delete/{id}', 'PastorController@destroy')->name('pastor_destroy');
	});

	//master wedding
	Route::group(['prefix' => 'wedding'], function () {
		Route::get('/', 'WeddingBlessController@index')->name('wedding_list');
		Route::get('/create', 'WeddingBlessController@create')->name('wedding_create');
		Route::post('/store', 'WeddingBlessController@store')->name('wedding_store');
		Route::get('/edit/{id}', 'WeddingBlessController@edit')->name('wedding_edit');
		Route::post('/update', 'WeddingBlessController@update')->name('wedding_update');
		Route::post('/delete/{id}', 'WeddingBlessController@destroy')->name('wedding_destroy');
	});

	//master baptism
	Route::group(['prefix' => 'baptism'], function () {
		Route::get('/', 'BaptismController@index')->name('baptism_list');
		Route::get('/create', 'BaptismController@create')->name('baptism_create');
		Route::post('/store', 'BaptismController@store')->name('baptism_store');
		Route::get('/edit/{id}', 'BaptismController@edit')->name('baptism_edit');
		Route::post('/update', 'BaptismController@update')->name('baptism_update');
		Route::post('/delete/{id}', 'BaptismController@destroy')->name('baptism_destroy');
	});
});

