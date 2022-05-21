<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDetmasivoidToTesoreriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tesorerias', function (Blueprint $table) {
            $table->unsignedBigInteger('detmasivo_id')->nullable()->after('cuenta_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tesorerias', function (Blueprint $table) {
            $table->dropColumn('detmasivo_id');
        });
    }
}
