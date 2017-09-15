<?php

use Illuminate\Database\Seeder;

class SellersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::find(4)->seller()->create([
            'phone' => '(67)0000-0000',
            'type_delivery'=>'seilá',
            'distance_delivery'=>'não-sei',
            'plates_quantity'=>'10',
        ]);

        \App\User::find(3)->seller()->create([
            'phone' => '(67)0000-0000',
            'type_delivery'=>'seilá',
            'distance_delivery'=>'não-sei',
            'plates_quantity'=>'10',
        ]);

    }
}
