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

Route::get('get-user-data/{user_id}','TestController@get_user_data');

Route::post('get-user-data-post' , 'TestController@get_user_data_post');
Route::post('get-user-data-post-curl' , 'TestController@get_user_data_post_curl');



//Route::get('/make-password-hash/{password}','AuthController@make_password_hash');
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');
Route::post('me', 'AuthController@me');
Route::post('payload', 'AuthController@payload');


