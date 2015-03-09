<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ProjectController extends Controller {

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function showProjects()
    {
        return view('home');
        #$addurl = action('App\Http\Controllers\ProjectController@addProject');
    }

    public function addProject()
    {
        return view('login');
    }

}