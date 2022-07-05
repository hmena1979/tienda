<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIgvToDetcotizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detcotizacions', function (Blueprint $table) {
            $table->unsignedTinyInteger('igv')->default(1)->after('cantidad');
            $table->decimal('pre_ini',12,4)->nullable()->after('igv');
        });

        Schema::table('detordcompras', function (Blueprint $table) {
            $table->unsignedTinyInteger('igv')->default(1)->after('cantidad');
            $table->decimal('pre_ini',12,4)->nullable()->after('igv');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detcotizacions', function (Blueprint $table) {
            $table->dropColumn('igv');
            $table->dropColumn('pre_ini');
        });

        Schema::table('detordcompras', function (Blueprint $table) {
            $table->dropColumn('igv');
            $table->dropColumn('pre_ini');
        });
    }
}
