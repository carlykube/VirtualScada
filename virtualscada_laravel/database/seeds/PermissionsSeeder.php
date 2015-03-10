<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 3/10/2015
 * Time: 3:07 PM
 */

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder {

    public function run()
    {
        DB::table('permissions')->delete();

        $user_ids = DB::table('users')->lists('id');
        $project_ids = DB::table('projects')->lists('id');

        App\Permission::create(array(
            'user_id' => $user_ids[0],
            'project_id' => $project_ids[0],
            'permissions' => 7,
        ));

    }

}