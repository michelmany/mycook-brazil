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
            'email' => 'michel@nitdesign.com.br',
            'name' => 'Michel Moraes',
            'cpf' => '12312312312',
            'active' => true,
            'role' => 'admin',
            'password' => bcrypt('nit@1049')
        ]);

        User::create([
            'email' => 'ale@nitdesign.com.br',
            'name' => 'Alexandra Carneiro',
            'role' => 'admin',
            'password' => bcrypt('nit123456')
        ]);

        User::create([
            'email' => 'alfmussi@yahoo.com.br',
            'name' => 'Alfredo',
            'role' => 'vendedor',
            'cpf' => '12312312312',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'rosinhagutierres@gmail.com',
            'name' => 'Rose de Fatma',
            'role' => 'vendedor',
            'cpf' => '80845428187',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'fernando@fernando.com.br',
            'name' => 'Fernando',
            'role' => 'comprador',
            'cpf' => '53551443734',
            'password' => bcrypt('123456')
        ]);

        User::create([
            'email' => 'cesinhagutierres@gmail.com',
            'name' => 'César Augusto',
            'role' => 'comprador',
            'cpf' => '53551443734',
            'password' => bcrypt('123456')
        ]);

    }
}
