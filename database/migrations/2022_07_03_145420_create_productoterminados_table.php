<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoterminadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productoterminados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->string('lote',15);
            $table->unsignedBigInteger('parte_id');
            $table->unsignedBigInteger('pproceso_id');
            $table->unsignedBigInteger('trazabilidad_id');
            $table->unsignedBigInteger('dettrazabilidad_id');
            $table->date('empaque');
            $table->date('vencimiento');
            $table->decimal('entradas');
            $table->decimal('salidas')->default(0);
            $table->decimal('saldo');
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
        Schema::dropIfExists('productoterminados');
    }
}
