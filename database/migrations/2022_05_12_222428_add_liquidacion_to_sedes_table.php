<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLiquidacionToSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sedes', function (Blueprint $table) {
            $table->string('lcompra_serie',4)->default('E001')->after('guia_corr');
            $table->integer('lcompra_corr')->nullable()->after('lcompra_serie');
        });

        Schema::table('rcompras', function (Blueprint $table) {
            $table->unsignedTinyInteger('liquidacion')->default(2)->after('almacen');
        });

        Schema::table('empresas', function (Blueprint $table) {
            $table->decimal('por_rentalq',12,2)->default(1.5)->after('monto_renta');
            $table->text('servidorguia')->nullable()->after('servidor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sedes', function (Blueprint $table) {
            $table->dropColumn('lcompra_serie');
            $table->dropColumn('lcompra_corr');
        });

        Schema::table('rcompras', function (Blueprint $table) {
            $table->dropColumn('liquidacion');
        });

        Schema::table('empresas', function (Blueprint $table) {
            $table->dropColumn('por_rentalq');
        });
    }
}
