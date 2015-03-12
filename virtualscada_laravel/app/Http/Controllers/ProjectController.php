<?php namespace App\Http\Controllers;

use Auth;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProjectRequest;

class ProjectController extends Controller {

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(Project $projects)
    {
        // $this->projects = Project::where('user_id', '=', Auth::id())->get();
        $this->middleware('auth');
    }

    public function index()
    {
        $projects = Project::ofUser(Auth::id())->get();
        return view('home', compact('projects'));
    }

    // show project with id if the user owns that project
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project, Request $request)
    {

        $project->update($request->all());
        return redirect('/home');
    }

    public function store(CreateProjectRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();

        Project::create($input);
        return redirect('projects');
    }
}