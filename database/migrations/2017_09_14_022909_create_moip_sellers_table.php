<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoipSellersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('moip_sellers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('moipAccount', 100)->index();
            $table->unique('moipAccount');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('data')->toJson();
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
        Schema::table('moip_sellers', function(Blueprint $table) {
            $table->dropForeign('moip_sellers_user_id_foreign');
            $table->dropUnique('moip_sellers_moipAccount_unique');
            $table->dropIndex('moip_sellers_moipAccount_index');
            $table->dropIfExists();
        });
    }
}
