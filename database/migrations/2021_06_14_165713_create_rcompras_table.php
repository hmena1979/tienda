<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRcomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rcompras', function (Blueprint $table) {
            $table->id();
            $table->integer('empresa_id')->default(1);
            $table->integer('sede_id')->default(1);
            $table->string('periodo',6);
            $table->string('peringreso',6)->nullable();
            $table->integer('contable')->default(1);//(1)Si / (2) No
            $table->integer('almacen')->default(2);//(2)Si / (1) No
            $table->integer('fpago')->default(1);//(1)Contado / (2) Credito
            $table->string('dias',3)->nullable();
            $table->date('fecha');
            $table->date('fechaingreso')->nullable();
            $table->date('vencimiento')->nullable();
            $table->date('cancelacion')->nullable();
            $table->date('fechaguia')->nullable();
            $table->string('numeroguia',20)->nullable();
            $table->string('moneda',3)->default('PEN');
            $table->decimal('tc',10,3)->nullable();
            $table->string('tipocomprobante_codigo',2);
            $table->integer('tipocomprobante_tipo')->nullable();
            $table->string('serie',4)->nullable();
            $table->string('numero',15);

            // $table->foreignId('cliente_id')->default(1)->constrained()->onupdate()->ondelete('set default');
            $table->unsignedBigInteger('cliente_id')->default(1);
            
            $table->string('tipooperacion_id',2)->nullable();
            $table->decimal('afecto',12,2)->nullable();
            $table->decimal('exonerado',12,2)->nullable();
            $table->decimal('impuesto',12,2)->nullable();
            $table->decimal('renta',12,2)->nullable();
            $table->decimal('isc',12,2)->nullable();
            $table->decimal('otros',12,2)->nullable();
            $table->decimal('icbper',12,2)->nullable();
            $table->decimal('total',12,2)->nullable();
            $table->decimal('pagado',12,2)->nullable();
            $table->decimal('saldo',12,2)->nullable();
            $table->string('mediopago',3)->nullable();
            $table->integer('cuenta_id')->nullable();
            $table->string('numerooperacion',15)->nullable();
            $table->integer('detraccion')->default(2);
            $table->string('detraccion_codigo',3)->nullable();
            $table->decimal('detraccion_tasa',10,2)->nullable();
            $table->decimal('detraccion_monto',12,2)->nullable();
            $table->decimal('detraccion_pagado',12,2)->nullable();
            $table->decimal('detraccion_saldo',12,2)->nullable();
            $table->string('detraccion_constancia',15)->nullable();
            $table->date('dr_fecha')->nullable();
            $table->string('dr_tipocomprobante_codigo',2)->nullable();
            $table->string('dr_serie',4)->nullable();
            $table->string('dr_numero',15)->nullable();
            $table->text('detalle')->nullable();
            $table->integer('completado')->default(2);
            $table->text('entregadopor')->nullable();
            $table->softDeletes();
            $table->timestamps();


            
            // $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
            // $table->foreignId('cliente_id')->nullable()->constrained('clientes')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rcompras');
    }
}
