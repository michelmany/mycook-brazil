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
        $user = \App\User::find(5);
        if(!$user->buyer) {
            $user->buyer()->create([
                'phone' => '67 992502088',
                'birth' => '1994-05-05'
            ]);
        }
    }
}
