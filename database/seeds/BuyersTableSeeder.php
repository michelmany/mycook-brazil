<?php

use Illuminate\Database\Seeder;

class BuyersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /** @var \App\User $user */
        $user = \App\User::find(1)->buyer()->create([
            'phone' => '2199994444',
            'birth' => '10101950'
        ]);

        /** @var \App\User $user */
        $user = \App\User::find(3)->buyer()->create([
            'phone' => '2199994444',
            'birth' => '10101950'
        ]);

        /** @var \App\User $user */
        $user = \App\User::find(4)->buyer()->create([
            'phone' => '67992502088',
            'birth' => '05051994'
        ]);

        /** @var \App\User $user */
        $user = \App\User::find(5)->buyer()->create([
            'phone' => '67992502088',
            'birth' => '05051994'
        ]);

        $cesar = \App\User::find(6)->buyer()->create([
            'phone' => '6992502088',
            'birth' => '05051994'
        ]);
    }
}
