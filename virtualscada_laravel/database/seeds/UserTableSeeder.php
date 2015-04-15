<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

public function run()
{
    DB::table('users')->delete();
    App\User::create(array(
        'name'     => 'Patrick Brannen',
        'email'    => 'pbrannen@smu.edu',
        'password' => Hash::make('awesome'),
    ));

    App\User::create(array(
        'name'     => 'Lauren McManamon',
        'email'    => 'lmcmanamon@smu.edu',
        'password' => Hash::make('awesome'),
    ));

    App\User::create(array(
        'name'     => 'Ketetha Olengue',
        'email'    => 'kolengue@smu.edu',
        'password' => Hash::make('awesome'),
        ));

    App\User::create(array(
        'name'     => 'Carly Kubacak',
        'email'    => 'ckubacak@smu.edu',
        'password' => Hash::make('awesome'),
    ));

    App\User::create(array(
        'name'     => 'Austin Heerwagen',
        'email'    => 'aheerwagen@smu.edu',
        'password' => Hash::make('awesome'),
    ));
}

}
