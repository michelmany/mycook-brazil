<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(SellersTableSeeder::class);
         $this->call(BuyersTableSeeder::class);
         $this->call(UserAddressesTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
    }
}
