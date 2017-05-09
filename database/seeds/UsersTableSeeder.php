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
            'cpf' => '12312312312',
            'active' => true,
            'role' => 'admin',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'michel@nitdesign.com.br',
            'name' => 'Michel Moraes',
            'cpf' => '12312312312',
            'active' => true,
            'role' => 'admin',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'shane@laraspace.in',
            'name' => 'Shane White',
            'cpf' => '12312312312',
            'active' => true,
            'role' => 'user',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'adam@laraspace.in',
            'name' => 'Adam David',
            'cpf' => '12312312312',
            'active' => true,
            'role' => 'user',
            'password' => bcrypt('123456')
        ]);
    }
}
