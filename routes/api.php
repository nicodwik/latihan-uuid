<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
        'prefix' => 'auth'
    ], function () {
    Route::post('register', 'AuthController@register');
    Route::post('verification', 'AuthController@verification');
    Route::post('regenerate-otp', 'AuthController@regenerateOtp');
    Route::post('update-password', 'AuthController@updatePassword');
    Route::post('login', 'AuthController@login');
});

Route::group([
        'prefix' => 'profile',
        'middleware' => 'auth'
    ], function () {
    Route::get('get-profile', 'ProfileController@getProfile');
    Route::post('update-profile', 'ProfileController@updateProfile');
});

Route::get('users', 'TestController@getUsers');
Route::delete('users/delete/{id}', 'TestController@removeUser');

Route::group([
    'prefix' => 'campaign',
    'middleware' => 'api'
], function () {
    Route::get('random/{count}', 'CampaignController@random');
    Route::get('/', 'CampaignController@index');
    Route::get('/{id}', 'CampaignController@detail');
    Route::post('store', 'CampaignController@store');
});

Route::group([
    'prefix' => 'blog',
    'middleware' => 'api'
], function () {
    Route::get('random/{count}', 'BlogController@random');
    Route::get('/', 'CampaignController@index');
    Route::post('store', 'BlogController@store');
});