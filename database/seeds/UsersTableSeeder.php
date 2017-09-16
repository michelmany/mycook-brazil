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
            'cpf' => '62437163093',
            'active' => true,
            'role' => 'admin',
            'password' => bcrypt('nit123456')
        ]);

        User::create([
            'email' => 'ale@nitdesign.com.br',
            'name' => 'Alexandra Carneiro',
            'role' => 'admin',
            'cpf' => '33604894549',
            'active' => true,
            'password' => bcrypt('nit123456')
        ]);

        User::create([
            'email' => 'alfmussi@yahoo.com.br',
            'name' => 'Alfredo',
            'role' => 'admin',
            'cpf' => '35676756802',
            'active' => true,
            'password' => bcrypt('nit123456')
        ]);
        
        User::create([
            'email' => 'cesinhagutierres@gmail.com',
            'name' => 'César Augusto',
            'role' => 'vendedor',
            'cpf' => '05070216147',
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


    }
}
