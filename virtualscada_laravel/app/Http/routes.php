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

route::get('/', 'WelcomeController@index');

Route::get('home', 'ProjectController@index');

// type php artisan route:list to see list of automated list of routes
Route::resource('projects', 'ProjectController');
Route::resource('modules', 'ModuleController');

Route::get('projects/open/{projects}', 'ProjectController@open');
Route::post('projects/addModule', 'ProjectController@addModule');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);