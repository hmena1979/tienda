<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmbarquesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('embarques', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->string('periodo',6);
            $table->text('lote',15)->nullable();
            $table->string('moneda',3)->default('USD');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('country_id');
            $table->string('booking',20)->nullable();
            $table->string('grt',15)->nullable();
            $table->unsignedBigInteger('transportista_id')->nullable();
            $table->string('grr',15)->nullable();
            $table->string('precinto_hl',30)->nullable();
            $table->string('factura_numero',15)->nullable();
            $table->date('factura_fecha')->nullable();//
            $table->decimal('valor_fob',12)->nullable();
            $table->decimal('otros_gastos',12)->nullable();
            $table->decimal('valor_venta',12)->nullable();
            $table->date('atd_paking')->nullable();//Fecha de Movimiento
            $table->date('stuffing_container')->nullable();//
            $table->string('nave',30)->nullable();
            $table->string('viaje',30)->nullable();
            $table->date('etd_pol')->nullable();//
            $table->date('atd_pol')->nullable();//
            $table->string('pol',20)->nullable();//
            $table->date('eta_pod')->nullable();//
            $table->date('ata_pod')->nullable();//
            $table->string('pod',30)->nullable();//
            $table->string('naviera',30)->nullable();//
            $table->string('contenedor',15)->nullable();
            $table->decimal('peso_neto',12)->nullable();
            $table->decimal('peso_bruto',12)->nullable();
            $table->decimal('tara',12)->nullable();
            $table->decimal('vgm',12)->nullable();
            $table->decimal('sacos',10)->nullable();
            $table->string('bl',20)->nullable();
            $table->string('precinto_linea',50)->nullable();
            $table->string('precinto_ag',30)->nullable();
            $table->string('producto')->nullable();
            $table->unsignedBigInteger('stuffing_id')->nullable();
            $table->unsignedBigInteger('ffw_id')->nullable();
            $table->unsignedBigInteger('agenciaaduana_id')->nullable();
            $table->unsignedBigInteger('release_id')->nullable();
            $table->unsignedTinyInteger('pago_flete')->default(2);
            $table->unsignedTinyInteger('pago_vb')->default(2);
            $table->unsignedTinyInteger('vbto')->default(2);
            $table->string('dam',20)->nullable();
            $table->unsignedTinyInteger('contabilidad')->default(2);
            $table->string('awb_dhl',20)->nullable();
            $table->unsignedBigInteger('pi2_id')->default(1);
            $table->unsignedBigInteger('py_id')->default(1);
            $table->unsignedBigInteger('payt_id')->default(1);
            $table->decimal('adv',12)->nullable();
            $table->decimal('balance',12)->nullable();
            $table->decimal('thirdpy',12)->nullable();
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
        Schema::dropIfExists('embarques');
    }
}
