<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLoteToPedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->string('lote',15)->nullable()->after('detdestino_id');
        });
        Schema::table('rventas', function (Blueprint $table) {
            $table->string('lote',15)->nullable()->after('detdestino_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pedidos', function (Blueprint $table) {
            $table->dropColumn('lote');
        });
        Schema::table('rventas', function (Blueprint $table) {
            $table->dropColumn('lote');
        });
    }
}
