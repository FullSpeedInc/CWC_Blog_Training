<?php

use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            0 => [
                'username'   => 'admin',
                'first_name' => 'admin firstname',
                'last_name'  => 'admin lastname',
                'role'       => 1,
                'password'   => Hash::make('password'),
            ],
            1 => [
                'username'   => 'user',
                'first_name' => 'user firstname',
                'last_name'  => 'user lastname',
                'role'       => 0,
                'password'   => Hash::make('password'),
            ]
        ];

        DB::table('users')->insert($users);
    }
}
