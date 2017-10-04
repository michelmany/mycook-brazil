<?php

use Illuminate\Database\Seeder;

class SystemCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\SystemCategory::create(['name' => 'Antepastos']);
        \App\Models\SystemCategory::create(['name' => 'Árabe']);
        \App\Models\SystemCategory::create(['name' => 'Bebidas']);
        \App\Models\SystemCategory::create(['name' => 'Brasileira']);
        \App\Models\SystemCategory::create(['name' => 'Doces']);
        \App\Models\SystemCategory::create(['name' => 'Bolos']);
    }
}
