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

Route::view('/{any?}', 'app');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['verified']], function () {
    Route::get('/verified', 'TestController@checkVerified');
});
Route::group(['middleware' => ['auth', 'isAdmin']], function () {
    Route::get('/admin', 'TestController@checkAdmin');
});

Route::get('users', function(){
    return view('users');
});


