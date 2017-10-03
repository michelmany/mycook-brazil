<?php

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductExtrasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::find(1)->extras()->create([
            'date' => 'Seg',
            'start_time' => '09:00',
            'end_time' => '22:00',
            'quantity' => 4,
        ]);
        Product::find(1)->extras()->create([
            'date' => 'Ter',
            'start_time' => '09:00',
            'end_time' => '22:00',
            'quantity' => 6,
        ]);
        Product::find(1)->extras()->create([
            'date' => 'Qua',
            'start_time' => '09:00',
            'end_time' => '22:00',
            'quantity' => 0,
        ]);
        Product::find(1)->extras()->create([
            'date' => 'Qui',
            'start_time' => '16:00',
            'end_time' => '22:00',
            'quantity' => 2,
        ]);
        Product::find(1)->extras()->create([
            'date' => 'Sex',
            'start_time' => '12:00',
            'end_time' => '18:00',
            'quantity' => 0,
        ]);
        Product::find(1)->extras()->create([
            'date' => 'Sáb',
            'start_time' => '10:00',
            'end_time' => '16:00',
            'quantity' => 7,
        ]);
        Product::find(1)->extras()->create([
            'date' => 'Dom',
            'start_time' => '09:00',
            'end_time' => '22:00',
            'quantity' => 8,
        ]);

        Product::find(2)->extras()->create([
            'date' => 'Seg',
            'start_time' => '09:00',
            'end_time' => '22:00',
            'quantity' => 4,
        ]);
        Product::find(2)->extras()->create([
            'date' => 'Ter',
            'start_time' => '09:00',
            'end_time' => '22:00',
            'quantity' => 6,
        ]);
        Product::find(2)->extras()->create([
            'date' => 'Qua',
            'start_time' => '09:00',
            'end_time' => '22:00',
            'quantity' => 0,
        ]);
        Product::find(2)->extras()->create([
            'date' => 'Qui',
            'start_time' => '16:00',
            'end_time' => '10:00',
            'quantity' => 2,
        ]);
        Product::find(2)->extras()->create([
            'date' => 'Sex',
            'start_time' => '16:00',
            'end_time' => '10:00',
            'quantity' => 0,
        ]);
        Product::find(2)->extras()->create([
            'date' => 'Sáb',
            'start_time' => '14:00',
            'end_time' => '22:00',
            'quantity' => 7,
        ]);
        Product::find(2)->extras()->create([
            'date' => 'Dom',
            'start_time' => '06:00',
            'end_time' => '16:00',
            'quantity' => 8,
        ]);

        Product::find(3)->extras()->create([
            'date' => 'Seg',
            'start_time' => '09:00',
            'end_time' => '22:00',
            'quantity' => 4,
        ]);
        Product::find(3)->extras()->create([
            'date' => 'Ter',
            'start_time' => '09:00',
            'end_time' => '14:00',
            'quantity' => 6,
        ]);
        Product::find(3)->extras()->create([
            'date' => 'Qua',
            'start_time' => '09:00',
            'end_time' => '22:00',
            'quantity' => 0,
        ]);
        Product::find(3)->extras()->create([
            'date' => 'Qui',
            'start_time' => '09:00',
            'end_time' => '19:00',
            'quantity' => 2,
        ]);
        Product::find(3)->extras()->create([
            'date' => 'Sex',
            'start_time' => '10:00',
            'end_time' => '14:00',
            'quantity' => 0,
        ]);
        Product::find(3)->extras()->create([
            'date' => 'Sáb',
            'start_time' => '10:00',
            'end_time' => '18:00',
            'quantity' => 7,
        ]);
        Product::find(3)->extras()->create([
            'date' => 'Dom',
            'start_time' => '09:00',
            'end_time' => '19:00',
            'quantity' => 8,
        ]);

        Product::find(4)->extras()->create([
            'date' => 'Seg',
            'start_time' => '08:00',
            'end_time' => '14:00',
            'quantity' => 4,
        ]);
        Product::find(4)->extras()->create([
            'date' => 'Ter',
            'start_time' => '09:00',
            'end_time' => '22:30',
            'quantity' => 6,
        ]);
        Product::find(4)->extras()->create([
            'date' => 'Qua',
            'start_time' => '16:00',
            'end_time' => '22:00',
            'quantity' => 0,
        ]);
        Product::find(4)->extras()->create([
            'date' => 'Qui',
            'start_time' => '09:00',
            'end_time' => '19:00',
            'quantity' => 2,
        ]);
        Product::find(4)->extras()->create([
            'date' => 'Sex',
            'start_time' => '09:00',
            'end_time' => '22:00',
            'quantity' => 0,
        ]);
        Product::find(4)->extras()->create([
            'date' => 'Sáb',
            'start_time' => '08:00',
            'end_time' => '12:00',
            'quantity' => 7,
        ]);
        Product::find(4)->extras()->create([
            'date' => 'Dom',
            'start_time' => '11:00',
            'end_time' => '16:00',
            'quantity' => 4,
        ]);
    }
}
