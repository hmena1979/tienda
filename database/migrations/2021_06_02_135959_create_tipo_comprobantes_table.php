<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoComprobantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_comprobantes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo',2); // grupo(1) + tipo(003) + correlativo(00005)
            $table->string('nombre');
            $table->integer('operacion')->default(1); //(1) Suma en RC / (2) Resta en RC
            $table->integer('dreferencia')->default(2); //(1) Si / (2) No
            $table->integer('tipo')->default(1); //(1)Impuesto / (2)Retención / (3)Ninguno
            $table->integer('rc')->default(1); //(1) Si / (2) No
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
        Schema::dropIfExists('tipo_comprobantes');
    }
}
