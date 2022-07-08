<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetsalcamarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detsalcamaras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salcamara_id');
            $table->unsignedBigInteger('pproceso_id');
            $table->unsignedBigInteger('trazabilidad_id');
            $table->unsignedBigInteger('dettrazabilidad_id');
            $table->string('lotes')->nullable();
            $table->decimal('cantidad')->nullable();
            $table->decimal('peso')->nullable();
            $table->decimal('total')->nullable();
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
        Schema::dropIfExists('detsalcamaras');
    }
}
