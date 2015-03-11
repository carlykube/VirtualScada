<?php namespace App\Http\Controllers;

use Auth;
use App\Project;
use App\Http\Requests\CreateProjectRequest;

class ProjectController extends Controller {

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(Project $projects)
    {
        // $this->projects = Project::where('owner_id', '=', Auth::id())->get();
        // $this->middleware('auth');
    }

    public function index()
    {
        $projects = Project::ofUser(Auth::id())->get();

        return view('home', compact('projects'));
    }

    // show project with id if the user owns that project
    public function show($id)
    {
        $project = Project::ofUser(Auth::id())->findOrFail($id);

        return view('project.show', compact('project'));
    }

    public function create()
    {
        return view('project.create');
    }

    public function edit(Project $project)
    {
        return view('project.edit', compact('project'));
    }

    public function update(Project $project, Request $request)
    {
        $project->fill(['id' => $request->get('id'), 
            'owner_id' => $srequest->get('owner_id'), 
            'name' => $request->get('name')])->save();
        
        return redirect('/home');
    }

    public function store(CreateProjectRequest $request)
    {
        $input = $request->all();
        $input['owner_id'] = Auth::id();

        Project::create($input);

        return redirect('project');
    }
}