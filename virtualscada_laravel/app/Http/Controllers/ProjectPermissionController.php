<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Permission;
use App\Project;
use App\User;
use Auth;
use Request;

class ProjectPermissionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Project $project)
	{
        $permissionUserData = [];
        foreach ($project->permissions as $permission)
            $permissionUserData[] = User::find($permission->user_id);
        return view('projects.permissions', ['project' => $project, 'permissionUserData' => $permissionUserData]);

//        dd($project->permissions);
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
	public function store(Project $project)
	{
        $input = Request::all();
        $user = User::where('email', '=', $input['email'])->first();
        if ($user != null)
        {
            // check if user already has permission to view project
            $existingPermissions = Permission::where('project_id', '=', $project->id)->where('user_id', '=', $user->id)->get();
            if (count($existingPermissions) > 0)
            {
                flash()->error($user->name . " already has permission to view this project");
                return redirect('/projects/'.$project->id.'/permissions');
            }

            // give user permission to view project
            $defaultPermission = ['project_id' => $project->id,
                                  'user_id' => $user->id,
                                  'open' => true,
                                  'edit' => false,
                                  'share' => false];
            $project->permissions()->create($defaultPermission);
            flash()->success("Project shared with " . $user->name);
            return redirect('/projects/'.$project->id.'/permissions');
        }

        flash()->error("User not found");
        return redirect('/projects/'.$project->id.'/permissions');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Project $project, $permissionId)
	{
		dd($project);
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
	public function destroy($id)
	{
		//
	}

}
