<?php namespace App\Http\Controllers;


require_once __DIR__.'/../../../vendor/autoload.php';

use Auth;
use App\Project;
use Request;
use App\Http\Requests\CreateProjectRequest;
use Symfony\Component\Process\Process;


class ProjectController extends Controller {

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct(Project $projects)
    {
        $this->middleware('auth');
    }

    /**
     * Return all of the logged in user's projects
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $projects = Project::ofUser(Auth::id())->get();
        return view('home', compact('projects'));
    }

    /**
     * Show some details about the project
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function show(Project $project)
    {
        // check that user is allowed to view project
        if(!Auth::user()->projects->contains($project))
        {
            return redirect('/');
        }

        return view('projects.show', compact('project'));
    }

    /**
     * Show form to create new project
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Allow the user to edit high-level properties of project
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function edit(Project $project)
    {
        // check that user is allowed to edit project
        if(!Auth::user()->projects->contains($project))
        {
            return redirect('/');
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Update project in the database
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Project $project)
    {
        // check that user is allowed to edit project
        if(!Auth::user()->projects->contains($project))
        {
            return redirect('/');
        }

        $project->update(Request::all());
        return redirect('/home');
    }

    /**
     * Store new project in the database
     *
     * @param CreateProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(CreateProjectRequest $request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();

        Project::create($input);
        return redirect('projects');
    }

    /**
     * Delete the selected project from database
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Project $project)
    {
        flash()->success('Project ' . $project->name . ' has been deleted');
        $project->delete();
        return redirect('/home');
    }

    /**
     * Show details of the project
     * THIS IS WHERE WE WILL RUN SIMULATIONS AND ADD MODULES
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function open(Project $project)
    {
        // check that user is allowed to view project
        if(!Auth::user()->projects->contains($project))
        {
            return redirect('/');
        }

        // executes relative to virtualscada_laravel/public
        $pyscript = '../moduleScripts/helloworld.py';

        // creates new process and gets output
        $process = new Process('python ../moduleScripts/helloworld.py');
        /*$process->run();

        // executes after the command finishes
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
*/
        $process->run(function ($type, $buffer) {
        if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });

        $output = $process->getOutput();
        //$cmd = "python $pyscript";

        // executing for Windows Machine
        //exec("$cmd", $output);

        // these commands *should* work to run the script on a linux machine
        //$command = escapeshellcmd($cmd);
        //$output = shell_exec($command);

        //$output = count($output) > 0 ? $output[0] : "";

        $modules = $project->modules;

        return view('projects.open', ['project' => $project, 'output' => $output, 'modules' => $modules]);
    }

    /**
     * Adds a module to a project
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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