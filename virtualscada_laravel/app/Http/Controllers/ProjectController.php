<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Project;

class ProjectController extends Controller {

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(Project $projects)
    {
        $this->projects = Project::where('owner_id', '=', Auth::id())->get();
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
        return view('home', ["projects"=>$this->projects]);
    }

    public function show($id)
    {
        /* display one project */
        if($id=="add") {
            $blankPrj = new Project();
            return view('project.add', compact('blankPrj'));
        }

        $project = Project::find($id);
        return view('project.home', compact('project'));
    }

    public function add(Request $request)
    {
        $newName = $request->get('name');
        Project::create(array(
            'name' => $request->get('name'),
            'owner_id' => Auth::id()
        ));

        return redirect('/home');
    }

    public function edit(Project $project, $id)
    {
        $project = Project::find($id);
        return view('project.edit', compact('project'));
    }

    public function update(Project $project, Request $request)
    {
        $project->fill(['id' => $request->get('id'), 
            'owner_id' => $srequest->get('owner_id'), 
            'name' => $request->get('name')])->save();
        
        return redirect('/home');
    }
}