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
        $user = \App\User::find(4)->buyer()->create([
            'phone' => '67 992502088',
            'birth' => '05-05-1994'
        ]);

        /** @var \App\User $user */
        $user = \App\User::find(5)->buyer()->create([
            'phone' => '67 992502088',
            'birth' => '05-05-1994'
        ]);

        $cesar = \App\User::find(6)->buyer()->create([
            'phone' => '67 992502088',
            'birth' => '05-05-1994'
        ]);
    }
}
