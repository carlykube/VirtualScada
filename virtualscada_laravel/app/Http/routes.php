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

use App\Module;
use App\Project;

Route::bind('projects', function($id)
{
	return Project::whereId($id)->first();

});

Route::bind('modules', function($id)
{
    return Module::find($id);

});

// type php artisan route:list to see list of automated list of routes
route::get('/', 'WelcomeController@index');

Route::get('home', 'ProjectController@index');

Route::get('projects/open/{projects}', 'ProjectController@open');

Route::resource('projects', 'ProjectController');

Route::resource('modules', 'ModuleController');

Route::resource('projects.permissions', 'ProjectPermissionController');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);