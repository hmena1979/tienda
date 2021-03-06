<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('camaras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transportista_id');
            $table->string('marca',50);
            $table->string('placa',15);
            $table->string('protocolo',25);
            $table->string('capacidad',15)->nullable();
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
        Schema::dropIfExists('camaras');
    }
}
