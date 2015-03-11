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

Route::bind('project', function($id)
{
	return \App\Project::whereId($id)->first();
});

Route::get('/', 'ProjectController@index');
Route::get('home', 'ProjectController@index');

# project functions
Route::get('project', 'ProjectController@index');
Route::get('project/create', 'ProjectController@create');
Route::get('project/{id}', 'ProjectController@show');
Route::post('project', 'ProjectController@store');

Route::get('project/{project}/edit', 'ProjectController@edit');
Route::patch('project/{id}', 'ProjectController@update');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);