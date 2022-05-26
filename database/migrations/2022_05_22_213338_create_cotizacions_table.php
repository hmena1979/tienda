<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCotizacionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            $table->integer('empresa_id')->default(1);
            $table->integer('sede_id')->default(1);
            $table->string('periodo',6);
            $table->date('fecha');
            $table->unsignedBigInteger('cliente_id');
            $table->string('moneda',3)->default('PEN');
            $table->string('numero',15);
            $table->string('contacto')->nullable();
            $table->unsignedTinyInteger('pprecio')->default(1);//(1-10) Evaluación de Precio
            $table->unsignedTinyInteger('ptiempo')->default(1);//(1-10) Evaluación de Tiempo de Entrega
            $table->unsignedTinyInteger('pcalidad')->default(1);//(1-10) Evaluación de Calidad
            // $table->unsignedTinyInteger('evaluacion')->default(0);//(1-3) Evaluación General del Pedido
            $table->decimal('total',12,2)->nullable();
            $table->text('observaciones')->nullable();
            $table->text('file')->nullable();
            $table->unsignedTinyInteger('estado')->default(1);//(1) Activo (2)No Activo
            
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
        Schema::dropIfExists('cotizacions');
    }
}
