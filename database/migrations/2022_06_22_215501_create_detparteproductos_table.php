<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetparteproductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detparteproductos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parte_id');
            $table->unsignedBigInteger('producto_id');
            $table->decimal('solicitado',12,2)->nullable();
            $table->decimal('devuelto',12,2)->nullable();
            $table->decimal('entregado',12,2)->nullable();
            $table->decimal('precio',12,2)->nullable();
            $table->decimal('total',12,2)->nullable();
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
        Schema::dropIfExists('detparteproductos');
    }
}
