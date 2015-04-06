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
        // check that user is allowed to view project
        if(!Auth::user()->projects->contains($project))
        {
            return redirect('/');
        }

        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function edit(Project $project)
    {
        // check that user is allowed to edit project
        if(!Auth::user()->projects->contains($project))
        {
            return redirect('/');
        }

        return view('projects.edit', compact('project'));
    }

    public function update(Project $project, Request $request)
    {
        // check that user is allowed to edit project
        if(!Auth::user()->projects->contains($project))
        {
            return redirect('/');
        }

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
        // check that user is allowed to view project
        if(!Auth::user()->projects->contains($project))
        {
            return redirect('/');
        }

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

        $moduleData = ['file_loc' => 'path\to\python\script',
                       'screen_loc' => 'position1'];

        if ($type == 'rtu')
        {
            $moduleData['name'] = 'RTU_name';
        }
        else if ($type == 'hmi')
        {
            $moduleData['name'] = 'HMI_name';
        }

        // add project to logged-in user's projects
        $project = Project::find($input['projectId']);
        $newModule = $project->modules()->create($moduleData);

        flash()->success('Your module has been added');

        return redirect('/projects/open/' . $project->id);
    }
}