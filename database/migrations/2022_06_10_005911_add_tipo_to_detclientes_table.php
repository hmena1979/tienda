<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTipoToDetclientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detclientes', function (Blueprint $table) {
            $table->unsignedTinyInteger('tipo')->default('1')->after('moneda'); //(1) Ahorro (2)Corriente (3)Maestra
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detclientes', function (Blueprint $table) {
            $table->dropColumn('tipo');
        });
    }
}
