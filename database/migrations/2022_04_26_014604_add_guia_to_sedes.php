<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGuiaToSedes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sedes', function (Blueprint $table) {
            $table->string('guia_serie', 4)->default('T001')->after('nota_corr');
            $table->integer('guia_corr')->nullable()->after('guia_serie');
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
            //
        });
    }
}
