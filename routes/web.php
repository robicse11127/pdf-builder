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

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('/dashboard', 'HomeController@index')->name('home');
    Route::resource('/forms', 'FormBuilder');
    Route::get('/generate_pdf/{id}', 'FormBuilder@generate_pdf');
});
