<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalcamarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salcamaras', function (Blueprint $table) {
            $table->id();
            $table->string('numero',6);
            $table->date('fecha');//Fecha de Movimiento
            $table->string('lotes',50)->nullable();
            $table->string('contenedor',15)->nullable();
            $table->string('precinto',15)->nullable();
            $table->unsignedTinyInteger('motivo')->default(1);//(1)Exportación (2)Muestreo
            $table->unsignedBigInteger('transportista_id')->nullable();
            $table->string('placas',50)->nullable();
            $table->string('grt',15)->nullable();
            $table->string('gr',15)->nullable();
            $table->decimal('pesoneto',10)->nullable();
            $table->decimal('sacos',10)->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedTinyInteger('estado')->default(1); //(1) Pendiente (2)Autorizado
            $table->unsignedBigInteger('user_id')->nullable();
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('salcamaras');
    }
}
