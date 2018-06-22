<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loadÅed by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('sms', 'UserController@store');
//Route::get('sms', 'UserController@store')->middleware('ipcheck');
Route::post('get-response', 'UserController@getSMSResponse');
Route::get('get-email', 'EmailController@store');

Route::get('test-store', 'TestController@testStore');
//Route::get('test', 'TestController@testHelper');
Route::post('test-post', 'TestController@testPostHelper');
Route::post('test-sms', 'UserController@sendSMS');
Route::post('test', 'TestController@index');