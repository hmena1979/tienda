<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOcompraIdToRcomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rcompras', function (Blueprint $table) {
            $table->unsignedBigInteger('ordcompra_id')->nullable()->after('total_masivo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rcompras', function (Blueprint $table) {
            $table->dropColumn('ordcompra_id');
        });
    }
}
