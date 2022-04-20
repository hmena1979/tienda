<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKardexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kardexes', function (Blueprint $table) {
            $table->id();
            $table->string('periodo',6);
            $table->unsignedTinyInteger('tipo')->default(1);//(1)Ingreso (2)Consumo directo (3)Salidas
            $table->unsignedBigInteger('operacion_id');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('cliente_id');
            $table->string('documento', 13);
            $table->string('proveedor');
            $table->date('fecha');
            $table->decimal('cant_ent',12,4)->nullable();
            $table->decimal('cant_sal',12,4)->nullable();
            $table->decimal('cant_sald',12,4)->nullable();
            $table->decimal('pre_compra',12,4)->nullable();
            $table->decimal('pre_prom',12,4)->nullable();
            $table->text('descrip')->nullable();
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
        Schema::dropIfExists('kardexes');
    }
}
