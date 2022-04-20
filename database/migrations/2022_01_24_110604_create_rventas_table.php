<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRventasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rventas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->unsignedBigInteger('sede_id')->default(1);
            $table->string('periodo',6);
            $table->unsignedTinyInteger('contable')->default(1);//(1)Si / (2) No
            $table->unsignedTinyInteger('tipo')->default(1);//(1)Venta / (2) Consumo

            $table->unsignedTinyInteger('fpago')->default(1);//(1)Contado / (2) Credito
            $table->string('dias',3)->nullable();
            $table->dateTime('fecha');
            // $table->time('hora');
            $table->dateTime('vencimiento')->nullable();
            $table->dateTime('cancelacion')->nullable();
            
            $table->string('moneda',3)->default('PEN');
            $table->decimal('tc',10,3)->nullable();

            $table->unsignedBigInteger('cliente_id')->default(1);
            $table->string('direccion')->nullable();
            $table->string('direnvio')->nullable();
            $table->unsignedBigInteger('detdestino_id')->nullable();
            $table->unsignedBigInteger('ccosto_id')->nullable();

            $table->string('tipocomprobante_codigo',2)->nullable();
            $table->string('serie',4)->nullable();
            $table->string('numero',15)->nullable();

            $table->decimal('gravado',12,2)->nullable();
            $table->decimal('exonerado',12,2)->nullable();
            $table->decimal('inafecto',12,2)->nullable();
            $table->decimal('exportacion',12,2)->nullable();
            $table->decimal('gratuito',12,2)->nullable();
            $table->decimal('igv',12,2)->nullable();
            $table->decimal('descuentos',12,2)->nullable();
            $table->decimal('icbper',12,2)->nullable();
            $table->decimal('total',12,2)->nullable();
            $table->decimal('pagado',12,2)->nullable();
            $table->decimal('saldo',12,2)->nullable();
            $table->decimal('pagacon',12,2)->nullable();

            $table->string('mediopago',3)->nullable();
            $table->integer('cuenta_id')->nullable();
            $table->string('numerooperacion',15)->nullable();

            $table->unsignedTinyInteger('detraccion')->default(2);
            $table->string('detraccion_codigo',3)->nullable();
            $table->decimal('detraccion_tasa',10,2)->nullable();
            $table->decimal('detraccion_monto',12,2)->nullable();

            $table->text('detalle')->nullable();//Glosa | Recibido por
            $table->unsignedBigInteger('zona_id')->nullable();
            $table->unsignedBigInteger('vendedor_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->unsignedTinyInteger('status')->default(1);
            $table->text('cdr')->nullable();

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
        Schema::dropIfExists('rventas');
    }
}
