<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 15)->unique();
            $table->tinyInteger('uses')->default(0);
            $table->text('settings');
            $table->timestamp('expires_in')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_coupons');
    }
}
