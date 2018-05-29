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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('sms', 'UserController@store');
//Route::get('sms', 'UserController@index')->middleware('ipcheck');

Route::get('test', 'UserController@testHelper');
Route::post('test-post', 'UserController@testPostHelper');
Route::post('test-sms', 'UserController@sendSMS');
Route::post('get-response', 'UserController@getSMSResponse');