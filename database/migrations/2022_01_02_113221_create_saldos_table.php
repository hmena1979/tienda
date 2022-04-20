<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaldosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saldos', function (Blueprint $table) {
            $table->id();
            $table->string('periodo',6);
            $table->unsignedBigInteger('producto_id');
            $table->decimal('inicial',10,2)->nullable();
            $table->decimal('entradas',10,2)->nullable();
            $table->decimal('salidas',10,2)->nullable();
            $table->decimal('saldo',10,2)->nullable();
            $table->decimal('precio',12,4)->nullable();
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
        Schema::dropIfExists('saldos');
    }
}
