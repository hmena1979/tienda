<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservacionesToDetingcamarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detingcamaras', function (Blueprint $table) {
            $table->string('observaciones')->nullable()->after('total');
        });

        Schema::table('detpartecamaras', function (Blueprint $table) {
            $table->string('observaciones')->nullable()->after('costo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detingcamaras', function (Blueprint $table) {
            $table->dropColumn('observaciones');
        });
        Schema::table('detpartecamaras', function (Blueprint $table) {
            $table->dropColumn('observaciones');
        });
    }
}
