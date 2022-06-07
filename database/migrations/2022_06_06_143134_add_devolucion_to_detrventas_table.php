<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDevolucionToDetrventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detrventas', function (Blueprint $table) {
            $table->decimal('devolucion',12,2)->nullable()->after('cantidad');
            $table->date('dfecha')->nullable()->after('devolucion');
            $table->text('motivo',100)->nullable()->after('dfecha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detrventas', function (Blueprint $table) {
            $table->dropColumn('devolucion');
            $table->dropColumn('dfecha');
            $table->dropColumn('motivo');
        });
    }
}
