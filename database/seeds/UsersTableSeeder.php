<?php

use Illuminate\Database\Seeder;
use Laraspace\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'erik.figueiredo@gmail.com',
            'name' => 'Jane Doe',
            'role' => 'admin',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'shane@laraspace.in',
            'name' => 'Shane White',
            'role' => 'user',
            'password' => bcrypt('hank@123')
        ]);

        User::create([
            'email' => 'adam@laraspace.in',
            'name' => 'Adam David',
            'role' => 'user',
            'password' => bcrypt('jesse@123')
        ]);
    }
}
