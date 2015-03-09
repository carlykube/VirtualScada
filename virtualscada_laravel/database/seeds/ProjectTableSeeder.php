<?php
 
use Illuminate\Database\Seeder;
 
class ProjectTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('projects')->delete();

        $user_ids = DB::table('users')->lists('id');

        App\Project::create(array(
            'owner_id' => $user_ids[0],
            'name'    => 'Monayyyy-Money',
         ));

        App\Project::create(array(
            'owner_id' => $user_ids[2],
            'name'    => 'Nu-New',
         ));

        App\Project::create(array(
            'owner_id' => $user_ids[3],
            'name'    => 'Boom-Bam',
         )); 
    }
 
}

