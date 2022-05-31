<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPedidoIdToRventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rventas', function (Blueprint $table) {
            $table->unsignedBigInteger('pedido_id')->nullable()->after('detdestino_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rventas', function (Blueprint $table) {
            $table->dropColumn('pedido_id');
        });
    }
}
