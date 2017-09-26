<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
            $table->text('payment')->nullable();
            /**
             * 0 - Aguardando
             * 1 - Encaminhando
             * 2 - Saiu para Entrega
             * 3 - Endereço não localizado
             * 4 - Entregue
             * 5 - Finalizado
             */
            $table->integer('status_delivery')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
}
