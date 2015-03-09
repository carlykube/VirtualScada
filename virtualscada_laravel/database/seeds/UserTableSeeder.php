<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{

public function run()
{
    DB::table('users')->delete();
    App\User::create(array(
        'name'     => 'Chris Sevilleja',
        'username' => 'sevilayha',
        'email'    => 'chris@scotch.io',
        'password' => Hash::make('awesome'),
    ));

    App\User::create(array(
        'name'     => 'George Clinton',
        'username' => 'george',
        'email'    => 'george@smu.edu',
        'password' => Hash::make('awesome'),
    ));

App\User::create(array(
        'name'     => 'Bill Nooner',
        'username' => 'bill',
        'email'    => 'bill@scotch.io',
        'password' => Hash::make('awesome'),
    ));

App\User::create(array(
        'name'     => 'Ambers Selleja',
        'username' => 'amber',
        'email'    => 'amber@scotch.io',
        'password' => Hash::make('awesome'),
    ));
}

}
