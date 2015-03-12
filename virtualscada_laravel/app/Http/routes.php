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

Route::bind('projects', function($id)
{
	return \App\Project::whereId($id)->first();
});

Route::get('/', function(){ 
	// msut put if statement because might already be logged in
	return view('auth/login'); });
Route::get('home', 'ProjectController@index');

// type php artisan route:list to see lsit of automated list of routes
Route::resource('projects', 'ProjectController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);