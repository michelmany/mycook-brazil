<?php

use App\Models\Seller;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Seller::find(1)->products()->create([
            'name' => 'Pizza Quatro Queijos',
            'desc' => 'Deliciosa Pizza Grande',
            'serve' => '4',
            'photo' => null,
            'price' => '49.90',
        ]);

        Seller::find(1)->products()->create([
            'name' => 'Bolo de Cenoura com Chocolate',
            'desc' => 'Bolo caseiro feito com muito amor',
            'serve' => '6',
            'photo' => null,
            'price' => '30.00',
        ]);
        Seller::find(2)->products()->create([
            'name' => 'Feijoada Carregada',
            'desc' => 'Feijoada Completa com farofa e couve',
            'serve' => '8',
            'photo' => null,
            'price' => '54.50',
        ]);
        Seller::find(2)->products()->create([
            'name' => 'Costela Gaúcha',
            'desc' => 'Tradicional Costela Gaúcha',
            'serve' => '10',
            'photo' => null,
            'price' => '69.40',
        ]);
    }
}
