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
	var_dump($id);
	return \App\Project::whereId($id)->first();

});

Route::get('/', 'ProjectController@getProjects');
Route::get('home', 'ProjectController@getProjects');

# project functions

Route::get('project/{id}', 'ProjectController@show');
Route::post('project/add', 'ProjectController@add');
Route::get('project/{id}/edit', 'ProjectController@edit');
Route::patch('project/{id}', 'ProjectController@update');
Route::get('project', 'ProjectController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);