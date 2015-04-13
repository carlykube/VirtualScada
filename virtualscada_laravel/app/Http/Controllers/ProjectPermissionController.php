<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Permission;
use App\Project;
use App\User;
use Auth;
use DB;
use Request;
use Response;

class ProjectPermissionController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Project $project)
	{
        $projectUsers = DB::table('permissions')
                            ->where('permissions.project_id', '=', $project->id)
                            ->leftJoin('users', 'permissions.user_id', '=', 'users.id')
                            ->select(['permissions.id', 'user_id', 'open', 'edit', 'share', 'name'  ])
                            ->get();

        return view('projects.permissions', ['project' => $project, 'projectUsers' => $projectUsers]);
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
     * Update the permissions for a project in the database
     *
     * @param Project $project
     * @param $permissionId
     * @return Response
     * @internal param int $id
     */
	public function update(Project $project, $permissionId)
	{
        $permission = Permission::find($permissionId);
        $newPermissions = Request::all();
        $username = User::find($permission->user_id)->name;

        // Do not allow project owner permissions to be modified
        if ($project->user_id == $permission->user_id)
        {
            flash()->error("Cannot edit the permissions for the project owner.");
            // redirect to permissions view
            return redirect('/projects/'.$project->id.'/permissions');
        }
        // if user granted edit access, ensure that user can also open project
        else if ($newPermissions['edit'] == true && $newPermissions['open'] == false)
        {
            $newPermissions['open'] = true;
            flash()->success("Since ".$username." is allowed to edit the project, we also granted 'open' access");
        }
        else
        {
            // flash name of updated user to screen
            flash()->success("Permissions updated for " . $username);
        }

        // update permission and redirect user
        Permission::find($permissionId)->update($newPermissions);
        return redirect('/projects/'.$project->id.'/permissions');
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
