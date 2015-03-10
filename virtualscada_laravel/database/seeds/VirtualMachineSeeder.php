<?php
/**
 * Created by PhpStorm.
 * User: Patrick
 * Date: 3/10/2015
 * Time: 3:05 PM
 */

use Illuminate\Database\Seeder;

class VirtualMachineSeeder extends Seeder {

    public function run()
    {
        DB::table('virtual_machines')->delete();

        $project_ids = DB::table('projects')->lists('id');

        App\VirtualMachine::create(array(
            'project_id' => $project_ids[0],
            'name'    => 'HMI',
            'file_loc' => './VirtualMachines/HMI.vmdk',
            'screen_loc' => 'position1',
        ));
    }

}