<?php namespace App\Http\Controllers;

use DB;
use Auth;
class ProjectController extends Controller {

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function showProjects()
    {
        /* Get all projects */
        $projects = DB::table('projects')->where('owner_id', Auth::id())->get();
        #dd($projects); die(var_dump($projects));

        return view('home', compact('projects'));
    }

    public function addProject()
    {
        return view('login');
    }

}