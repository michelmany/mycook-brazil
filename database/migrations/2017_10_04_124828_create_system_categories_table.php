<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->unique();
            $table->index('name');
            $table->boolean('status')->default(true);
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
        Schema::table('system_categories', function(Blueprint $table) {
            $table->dropUnique('system_categories_name_unique');
            $table->dropIndex('system_categories_name_index');
            $table->dropIfExists();
        });
    }
}
