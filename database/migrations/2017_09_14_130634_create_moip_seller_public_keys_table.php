<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoipSellerPublicKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moip_seller_public_keys', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('moip_seller_id');
            $table->foreign('moip_seller_id')->references('id')->on('moip_sellers')->onDelete('cascade');
            $table->text('data');
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
        Schema::dropIfExists('moip_seller_public_keys');
    }
}
