<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateSellerTurnsFieldsNullableAndDropFormacao extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sellers', function (Blueprint $table) {
            $table->string('phone')->nullable()->change();
            $table->string('phone2')->nullable(false)->change();
            $table->string('type_delivery')->nullable()->change();
            $table->string('plates_quantity')->nullable()->change();
            $table->string('distance_delivery')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
