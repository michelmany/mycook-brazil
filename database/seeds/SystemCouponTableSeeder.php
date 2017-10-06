<?php

use Illuminate\Database\Seeder;

class SystemCouponTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Cupom desconto de 10%
         */
        $coupon10 = new \App\Models\SystemCoupon();
        $coupon10->code = '10OFF';
        $coupon10->expires_in = \Carbon\Carbon::now()->addDays(5);
        $coupon10->settings = [
            'minimum_purchase' => 150.00,
            'limit_of_user' => 20,
            'discount' => 10
        ];
        $coupon10->save();

        /**
         * Cupom desconto de 5%
         */
        $coupon05 = new \App\Models\SystemCoupon();
        $coupon05->code = '05OFF';
        $coupon05->expires_in = \Carbon\Carbon::now()->addDays(5);
        $coupon05->settings = [
            'minimum_purchase' => 110.00,
            'limit_of_user' => 15,
            'discount' => 5
        ];
        $coupon05->save();

    }
}
