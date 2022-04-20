<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 11);
            $table->string('razsoc', 100);
            $table->string('nomcomercial', 100)->nullable();
            $table->string('usuario', 15)->default('MODDATOS');
            $table->string('clave', 15)->default('moddatos');
            $table->text('apitoken')->nullable();
            $table->text('servidor')->nullable();
            $table->text('dominio')->nullable();
            $table->string('cuenta')->nullable();
            
            $table->decimal('por_igv',12,2)->default(18);
            $table->decimal('por_renta',12,2)->default(8);
            $table->decimal('monto_renta',12,2)->default(1500);
            $table->decimal('icbper',12,2)->nullable();
            $table->decimal('maximoboleta',12,2)->default(700);
            ////////////////////
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
        Schema::dropIfExists('empresas');
    }
}
