<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddConfidencialToClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->string('contacto',60)->nullable()->after('nomcomercial');
            $table->unsignedTinyInteger('confidencial')->default(2)->after('email');
            $table->unsignedBigInteger('country_id')->default(1)->after('confidencial');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            $table->dropColumn('contacto');
            $table->dropColumn('confidencial');
            $table->dropColumn('country_id');
        });
    }
}
