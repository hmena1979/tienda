<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetrventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detrventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rventa_id');
            $table->unsignedBigInteger('producto_id');
            $table->string('adicional')->nullable();
            $table->unsignedTinyInteger('grupo');//(1)Producto | (2)Servicio
            $table->decimal('cantidad',10,2);
            $table->decimal('preprom',10,2)->nullable();
            $table->decimal('precio',10,2);
            $table->decimal('icbper',12,2)->nullable();
            $table->decimal('subtotal',10,2);
            $table->string('afectacion_id',2)->default('10');
            $table->string('vence',10)->nullable();
            $table->string('lote',15)->nullable();
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
        Schema::dropIfExists('detrventas');
    }
}
