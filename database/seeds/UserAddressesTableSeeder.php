<?php

use App\User;
use Illuminate\Database\Seeder;

class UserAddressesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Vendedor
        User::find(3)->addresses()->create(
            [
                "name" => null,
                "cep" => "79094090",
                "address" => "Rua Dantas Barreto",
                "number" => "803",
                "complement" => null,
                "neighborhood" => "Jardim Tijuca",
                "city" => "Campo Grande",
                "state" => "MS",
                "longitude" => "-54.6625294",
                "latitude" => "-20.5140515",
            ]
        );

        User::find(4)->addresses()->create(
            [
                "name" => null,
                "cep" => "79094090",
                "address" => "Rua Dantas Barreto",
                "number" => "803",
                "complement" => null,
                "neighborhood" => "Jardim Tijuca",
                "city" => "Campo Grande",
                "state" => "MS",
                "longitude" => "-54.6625294",
                "latitude" => "-20.5140515",
            ]
        );

        // Comprador
        User::find(5)->addresses()->create(
            [
                "name" => null,
                "cep" => "79094090",
                "address" => "Rua Dantas Barreto",
                "number" => "1047",
                "complement" => null,
                "neighborhood" => "Jardim Tijuca",
                "city" => "Campo Grande",
                "state" => "MS",
                "longitude" => "-54.6625294",
                "latitude" => "-20.5140515",
            ]
        );

        User::find(6)->addresses()->create(
            [
                "name" => null,
                "cep" => "79094090",
                "address" => "Rua Dantas Barreto",
                "number" => "1047",
                "complement" => null,
                "neighborhood" => "Jardim Tijuca",
                "city" => "Campo Grande",
                "state" => "MS",
                "longitude" => "-54.6625294",
                "latitude" => "-20.5140515",
            ]
        );

    }
}
