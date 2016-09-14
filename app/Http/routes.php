<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

	/*for customer*/
Route::group(['middleware' => 'web'], function(){

	Route::get('/', 'CustomerController@index');
	Route::get('/customers', 'CustomerController@index');
	Route::post('/customers', 'CustomerController@store');
	Route::put('/customers/{id}', 'CustomerController@update');
	Route::delete('/customers/{id}', 'CustomerController@destroy');
	Route::get('/customers/{id}', 'CustomerController@show');
	Route::get('/customers/page/{page}/item/{item}', 'CustomerController@listCustomer');
	Route::get('/customers/page/{page}/item/{item}/{key}', 'CustomerController@search');
});

/* for customer device */

Route::group(['middleware' => 'web'], function(){

	Route::post('/customer/devices', 'CusdevController@store');
	Route::get('/customer/devices/{id}', 'CusdevController@edit');
	Route::put('/customers/devices/{id}', 'CusdevController@update');
	Route::delete('/customer/devices/{id}', 'CusdevController@destroy');
	Route::get('/customer/{id}/devices/page/{page}/item/{item}', 'CusdevController@listCusDevices');
	
});
	
	/*for devices*/

Route::group(['middleware' => 'web'], function(){
	Route::get('/devices', 'DeviceController@index');
	Route::post('/devices', 'DeviceController@store');
	Route::delete('/devices/{id}', 'DeviceController@destroy');
	Route::put('/devices/{id}', 'DeviceController@update');
	Route::get('/devices/{id}', 'DeviceController@show');

	Route::get('/devices/page/{page}/item/{limit}/', 'DeviceController@listDevice');
	Route::get('/devices/page/{page}/item/{limit}/{key}', 'DeviceController@search');
});

/*for user*/
Route::group(['middleware' => 'web'], function(){
	Route::get('/users', 'UserController@index');
	Route::post('/users', 'UserController@store');
	Route::get('/users/{id}', 'UserController@edit');
	Route::post('/users/{id}', 'UserController@update');
	Route::delete('/users/{id}', 'UserController@destroy');
	Route::get('/users/login', 'UserController@login');
	Route::get('/users/page/{pid}/item/{limit}/', 'UserController@listUser');

	Route::get('/users/page/{page}/item/{limit}/', 'UserController@listUser');
});
/*Status*/
Route::group(['middleware' => 'web'], function(){
	Route::get('/role', 'RoleController@index');
	Route::get('/role/all', 'RoleController@all');
});


