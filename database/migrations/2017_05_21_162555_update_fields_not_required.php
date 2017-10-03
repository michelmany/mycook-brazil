<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFieldsNotRequired extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->nullable()->change();
        });
        Schema::table('buyers', function (Blueprint $table) {
            $table->string('birth')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cpf')->change();
        });
        Schema::table('buyers', function (Blueprint $table) {
            $table->string('birth')->change();
        });
    }
}
