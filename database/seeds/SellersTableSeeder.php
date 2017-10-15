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
            'phone' => '67999994444'
        ]);

        \App\User::find(5)->seller()->create([
            'phone' => '67999998822'
        ]);

    }
}
