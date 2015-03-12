<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

public function run()
{
    DB::table('users')->delete();
    App\User::create(array(
        'name'     => 'Patrick Brannen',
        'email'    => 'patrick@smu.edu',
        'password' => Hash::make('awesome'),
    ));

    App\User::create(array(
        'name'     => 'Lauren McManamon',
        'email'    => 'lauren@smu.edu',
        'password' => Hash::make('awesome'),
    ));

    App\User::create(array(
        'name'     => 'Ketetha Olengue',
        'email'    => 'ketetha@smu.edu',
        'password' => Hash::make('awesome'),
        ));

    App\User::create(array(
        'name'     => 'Carly Kubacak',
        'email'    => 'carly@smu.edu',
        'password' => Hash::make('awesome'),
        ));

    App\User::create(array(
        'name'     => 'Austin Heerwagen',
        'email'    => 'austin@smu.edu',
        'password' => Hash::make('awesome'),
    ));
}

}
