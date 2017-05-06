<?php

use Illuminate\Database\Seeder;
use App\User;

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
            'name' => 'Erik Figueiredo',
            'role' => 'admin',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'michel@nitdesign.com.br',
            'name' => 'Michel Moraes',
            'role' => 'admin',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'shane@laraspace.in',
            'name' => 'Shane White',
            'role' => 'user',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'adam@laraspace.in',
            'name' => 'Adam David',
            'role' => 'user',
            'password' => bcrypt('123456')
        ]);
    }
}
