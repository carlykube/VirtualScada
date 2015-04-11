<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\Module;
use App\Project;
use Response;

class ModuleController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
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

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Module $module)
	{
        $projectId = $module->project->id;
        flash()->success('Module ' . $module->name . ' has been deleted');
        $module->delete();
        return redirect('/projects/open/' . $projectId);
	}

}
