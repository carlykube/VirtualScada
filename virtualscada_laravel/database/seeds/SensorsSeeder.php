<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 3/10/2015
 * Time: 3:06 PM
 */

use Illuminate\Database\Seeder;

class SensorsSeeder extends Seeder {

    public function run()
    {
        DB::table('sensors')->delete();

        $project_ids = DB::table('projects')->lists('id');

        App\Sensor::create(array(
            'owner_id' => $projects_ids[0],
            'name'    => 'Valve',
            'data_loc' => './Sensors/Valve1.csv',

        ));
    }

}