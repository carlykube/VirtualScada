<?php namespace App\Http\Controllers;

use Auth;
use App\Project;
use DB;

class ProjectController extends Controller {

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(Project $projects)
    
        $this->projects = Project::where('owner_id', '=', Auth::id());
        $this->middleware('auth');
        /* get id of one project */

    }

    /**
     * Show the profile for the given user.
     *
     * @return Response
     */
    public function getProjects()
    {
        /* Get all projects */
        return view('home', compact($this->projects));
    }

    public function showProject($id)
    {
        /* display one project */
        if($id=="add") {
            return view('project.add');
        }

        $project = Project::find($id);
        return view('project.home', compact('project'));
    }
}