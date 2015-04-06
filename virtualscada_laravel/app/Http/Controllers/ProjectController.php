<?php namespace App\Http\Controllers;

use Auth;
use App\Project;
use Request;
use App\Http\Requests\CreateProjectRequest;

class ProjectController extends Controller {

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(Project $projects)
    {
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

    public function open(Project $project)
    {
        // python commands for windows
        // executes relative to virtualscada_laravel/public
        $pyscript = '..\\moduleScripts\\helloworld.py';
        $cmd = "python $pyscript";
        exec("$cmd", $output);

        // these commands *should* work to run the script on a linux machine
        //  $command = escapeshellcmd($cmd);
        //  $output = shell_exec($command);

        $output = count($output) > 0 ? $output[0] : "";

        return view('projects.open', ['project' => $project, 'output' => $output]);
    }

    public function addModule()
    {
        $input = Request::all();
        $type = $input['module'];

        if ($type == 'rtu')
        {
            //add rtu to project
            return "ADD RTU (not working yet...)";
        }
        else if ($type == 'hmi')
        {
            return "ADD HMI (not working yet...)";
        }
    }
}