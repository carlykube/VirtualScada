<?php namespace App\Http\Controllers;

use DB;
use Auth;

class ProjectController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function getProjects()
    {
        /* Get all projects */
        $projects = DB::table('projects')->where('owner_id', Auth::id())->get();
        #dd($projects); die(var_dump($projects));

        return view('home', compact('projects'));
    }

    public function showProject()
    {
        /* display one project */
    }
    
    public function addProject()
    {
        return view('home');
    }

}