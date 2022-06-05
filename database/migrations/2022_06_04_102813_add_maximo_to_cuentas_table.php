<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaximoToCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuentas', function (Blueprint $table) {
            $table->decimal('maximo',12,2)->nullable()->after('numerocta');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuentas', function (Blueprint $table) {
            $table->dropColumn('maximo');
        });
    }
}
