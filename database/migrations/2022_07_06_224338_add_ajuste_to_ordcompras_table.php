<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAjusteToOrdcomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ordcompras', function (Blueprint $table) {
            $table->decimal('ajuste')->nullable()->after('estado');
        });
        Schema::table('cotizacions', function (Blueprint $table) {
            $table->decimal('ajuste')->nullable()->after('estado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ordcompras', function (Blueprint $table) {
            $table->dropColumn('ajuste');
        });
        Schema::table('cotizacions', function (Blueprint $table) {
            $table->dropColumn('ajuste');
        });
    }
}
