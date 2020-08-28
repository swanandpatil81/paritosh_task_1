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

/*Route::get('/', function () {
    return view('welcome');
});
*/

//Route::get('/Employee-Details/{page_no?}/{q_search?}/{txt_search?}','IndexController@emp_details');

//Route::get('pdf-test' , 'TestController@pdf_test');


Route::get('/', 'LoginController@index');
Route::post('/check-login', 'LoginController@check_login');
Route::get('/logout', 'LoginController@logout');
Route::get('/create-password/{password}', 'LoginController@create_password');


Route::group(['middleware' => ['checkSession']], function () {

	Route::get('/dashboard', 'HomeController@index');

	Route::get('/distance_calc' , 'HomeController@distance_calc');

});	