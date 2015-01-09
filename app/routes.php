<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});
Route::post('user/validate/', 'UserController@validate');
Route::post('user/auth/', 'UserController@auth');
Route::get('login', function()
{
  return Response::json(array("error" => true));
});
Route::get('user/logout', function()
{
  Auth::logout();
  return Response::json(array("success" => true));
});
Route::get('profile', array('before' => 'auth', function()
{
    // Only authenticated users may enter...
    return Response::json(array("secure_data" => "secret stuff!"));
}));
