<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateOrderDeliveryDatas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_delivery_datas', function (Blueprint $table) {
            //
            $table->unsignedInteger('order_id');
            $table->foreign('order_id')->references('id')->on('addresses')->onDelete('cascade');
            $table->unsignedInteger('address_id');
            $table->foreign('address_id')->references('id')->on('addresses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_delivery_datas', function (Blueprint $table) {
            //
            $table->dropForeign('order_delivery_datas_order_id_foreign');
            $table->dropForeign('order_delivery_datas_address_id_foreign');
        });
    }
}
