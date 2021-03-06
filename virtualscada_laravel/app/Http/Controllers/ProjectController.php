<?php namespace App\Http\Controllers;


require_once __DIR__.'/../../../vendor/autoload.php';

use App\Downtime;
use App\User;
use Auth;
use App\Project;
use DB;
use Illuminate\Database\Eloquent\Model;
use Request;
use App\Http\Requests\CreateProjectRequest;
use Symfony\Component\Process\Process;


/**
 * Controller for each Project class
 *
 * Class ProjectController
 * @package App\Http\Controllers
 */
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
        $downtimes = [];

        if (Auth::user()->admin){
            $downtimes = Downtime::latest('start_time')->future()->get();
//                DB::table('downtime')->future()->get();
        }

        return view('home', ['projects' => $projects, 'downtimes' => $downtimes]);
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

        $owner = $project->user;
        $owner['password'] = "";
        $owner['remember_token'] = "";

        $project['number_hmi'] = $project->modules()->where('type', '=', 'hmi')->count();
        $project['number_rtu'] = $project->modules()->where('type', '=', 'rtu')->count();
        $project['number_plc'] = $project->modules()->where('type', '=', 'plc')->count();
        $project['number_sensor'] = $project->modules()->where('type', '=', 'sensor')->count();

        return view('projects.show', ['project' => $project, 'owner' => $owner ]);
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
     * Edit the project permissions
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function editPermissions(Project $project)
    {
        // check that user is allowed to edit project
        if(!Auth::user()->projects->contains($project))
        {
            return redirect('/');
        }

        return view('projects.editPermissions', compact('project'));
    }

    /**
     * Update the project permissions
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updatePermissions(Project $project)
    {
        // check that user is allowed to edit project
        if(!Auth::user()->projects->contains($project))
        {
            return redirect('/');
        }
        dd(Request::all());
    }
}