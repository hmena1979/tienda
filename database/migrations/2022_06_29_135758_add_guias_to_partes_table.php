<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuiasToPartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partes', function (Blueprint $table) {
            $table->string('guias_envasado')->nullable()->after('costoproductos');
            $table->string('guias_envasado_crudo')->nullable()->after('guias_envasado');
            $table->string('guias_camara')->nullable()->after('guias_envasado_crudo');
            $table->string('guias_almacen')->nullable()->after('guias_camara');
            $table->string('guias_residuos')->nullable()->after('guias_almacen');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('partes', function (Blueprint $table) {
            $table->dropColumn('guias_envasado');
            $table->dropColumn('guias_envasado_crudo');
            $table->dropColumn('guias_camara');
            $table->dropColumn('guias_almacen');
            $table->dropColumn('guias_residuos');
        });
    }
}
