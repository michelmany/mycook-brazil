<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDeliveryDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_delivery_datas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day');
            $table->string('fulldate');
            $table->timestamp('time');
            $table->unsignedInteger('order_id');
//            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
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
     //   Schema::dropIfExists('order_delivery_datas');

        Schema::table('order_delivery_datas', function (Blueprint $table) {
//            $table->dropForeign('order_delivery_datas_order_id_foreign');
            $table->dropForeign('order_delivery_datas_address_id_foreign');
            $table->dropIfExists();
        });
    }
}
