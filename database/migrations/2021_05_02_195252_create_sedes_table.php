<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedes', function (Blueprint $table) {
            $table->id();
            $table->integer('empresa_id')->default(1);
            $table->integer('principal')->default(2);
            $table->string('nombre', 30)->nullable();
            $table->string('periodo', 6)->nullable();
            $table->string('ubigeo', 6)->nullable();
            $table->string('direccion', 100)->nullable();
            $table->string('urbanizacion', 25)->nullable();
            $table->string('provincia', 30)->nullable();
            $table->string('departamento', 30)->nullable();
            $table->string('distrito', 30)->nullable();
            $table->string('pais', 30)->default('PE');
            $table->string('telefono', 30)->nullable();

            $table->string('factura_serie', 4)->nullable();
            $table->integer('factura_corr')->nullable();

            $table->string('boleta_serie', 4)->nullable();
            $table->integer('boleta_corr')->nullable();

            $table->string('ncfac_serie', 4)->nullable();
            $table->integer('ncfac_corr')->nullable();

            $table->string('ncbol_serie', 4)->nullable();
            $table->integer('ncbol_corr')->nullable();
            
            $table->string('ndfac_serie', 4)->nullable();
            $table->integer('ndfac_corr')->nullable();

            $table->string('ndbol_serie', 4)->nullable();
            $table->integer('ndbol_corr')->nullable();

            $table->string('consumo_serie', 4)->nullable();
            $table->integer('consumo_corr')->nullable();

            $table->string('nota_serie', 4)->nullable();
            $table->integer('nota_corr')->nullable();
            
            $table->string('factura_conting_serie', 4)->nullable();
            $table->integer('factura_conting_corr')->nullable();
            
            $table->string('boleta_conting_serie', 4)->nullable();
            $table->integer('boleta_conting_corr')->nullable();

            $table->string('mediopago',3)->default('008');
            $table->integer('cuenta_id')->nullable();

            $table->string('tipocomprobante_codigo',2)->default('03');
            $table->unsignedBigInteger('cliente_id')->default(1);
            $table->unsignedTinyInteger('impresion')->default(1); //(1) Ticket (2) Formato

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
        Schema::dropIfExists('sedes');
    }
}
