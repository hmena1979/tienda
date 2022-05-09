<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriaprimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiaprimas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->string('periodo',6);
            $table->string('lote',15)->nullable();
            $table->unsignedBigInteger('cliente_id')->nullable();
            $table->unsignedBigInteger('rcompra_id')->nullable();
            $table->string('certprocedencia',10)->nullable();
            $table->unsignedBigInteger('transportista_id')->nullable();
            $table->unsignedBigInteger('chofer_id')->nullable();
            $table->unsignedBigInteger('camara_id')->nullable();
            $table->unsignedBigInteger('empacopiadora_id')->nullable();
            $table->unsignedBigInteger('acopiador_id')->nullable();
            $table->unsignedBigInteger('embarcacion_id')->nullable();
            $table->unsignedBigInteger('muelle_id')->nullable();
            $table->string('remitente_guia',15)->nullable();
            $table->string('transportista_guia',15)->nullable();
            $table->string('ticket_balanza',15)->nullable();
            $table->string('batch',3)->nullable();
            $table->integer('cajas')->nullable();
            $table->decimal('pplanta', 12, 2)->nullable();
            $table->date('fpartida')->nullable();
            $table->date('fllegada')->nullable();
            $table->date('ingplanta')->nullable();
            $table->time('hinicio')->nullable();
            $table->time('hfin')->nullable();
            $table->decimal('precio', 10, 2)->nullable();
            $table->string('lugar',20)->default('PAITA')->nullable();
            $table->unsignedBigInteger('producto_id')->nullable();
            $table->decimal('destare', 10, 2)->nullable();
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
        Schema::dropIfExists('materiaprimas');
    }
}
