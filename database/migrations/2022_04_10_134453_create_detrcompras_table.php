<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetrcomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detrcompras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rcompra_id');
            $table->unsignedInteger('detdestino_id');
            $table->unsignedBigInteger('ccosto_id');
            $table->decimal('monto',12,2);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detrcompras');
    }
}
