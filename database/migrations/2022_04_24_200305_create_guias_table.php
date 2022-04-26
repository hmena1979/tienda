<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->unsignedBigInteger('sede_id')->default(1);
            $table->string('periodo',6);

            $table->string('tipdoc_relacionado_id',2);
            $table->string('numdoc_relacionado',15);

            $table->dateTime('fechatraslado');
            $table->string('motivotraslado_id',2);
            $table->string('modalidadtraslado_id',2);
            $table->string('puerto',3)->nullable();
            $table->boolean('transbordo')->default(false);
            $table->decimal('pesototal',12,2);
            $table->string('contenedor',10)->nullable();
            
            $table->string('tipocomprobante_codigo',2)->default('09');
            $table->string('serie',4)->nullable();
            $table->string('numero',15)->nullable();
            $table->dateTime('fecha');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('tercero_id')->nullable();
            $table->string('observaciones')->nullable();

            $table->string('ubigeo_partida',6);
            $table->string('punto_partida',100);
            $table->string('ubigeo_llegada',6);
            $table->string('punto_llegada',100);

            $table->string('tipodoctransportista_id',1)->nullable();
            $table->string('numdoctransportista',15)->nullable();
            $table->string('razsoctransportista',60)->nullable();
            $table->string('placa',10)->nullable();
            $table->string('tipodocchofer_id',1)->nullable();
            $table->string('documentochofer',15)->nullable();

            $table->unsignedTinyInteger('status')->default(1);
            $table->text('cdr')->nullable();
            $table->text('baja')->nullable();
            $table->unsignedTinyInteger('anulado')->default(2);

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
        Schema::dropIfExists('guias');
    }
}
