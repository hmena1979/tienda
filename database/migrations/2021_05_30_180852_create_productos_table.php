<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->integer('sede_id')->default(1);
            $table->unsignedTinyInteger('grupo')->default(1); //(1)Productos / (2)Servicios
            $table->unsignedBigInteger('tipoproducto_id');
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('detallada')->nullable();
            $table->string('imagen')->nullable();
            $table->string('umedida_id',3)->default('ZZ');
            $table->string('afectacion_id',2)->default('10');
            $table->unsignedTinyInteger('icbper')->default(2);
            $table->unsignedTinyInteger('lotevencimiento')->default(2);
            $table->unsignedTinyInteger('ctrlstock')->default(1);
            $table->decimal('stock',12,4)->nullable();
            $table->decimal('stockmin',12,2)->nullable();
            $table->decimal('precompra',10,2)->nullable();
            
            $table->decimal('utilidad_pen',10,2)->nullable();
            $table->decimal('utilidad_usd',10,2)->nullable();
            
            $table->decimal('preventamin_pen',10,4)->nullable();
            $table->decimal('preventamin_usd',10,4)->nullable();
            $table->decimal('preventa_pen',10,4)->nullable();
            $table->decimal('preventa_usd',10,4)->nullable();
            $table->string('codigo',9); // grupo(1) + ID Correlativo(00000008)
            $table->string('codigobarra',15)->nullable();
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
        Schema::dropIfExists('productos');
    }
}
