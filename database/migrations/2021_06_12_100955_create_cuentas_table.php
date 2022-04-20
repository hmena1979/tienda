<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->unsignedBigInteger('sede_id')->default(1);
            $table->string('nombre');
            $table->string('moneda',3)->default('PEN');
            $table->unsignedTinyInteger('tipo')->default(1);//(1)Banco / (2) Caja
            $table->unsignedBigInteger('banco_id')->default(1);
            $table->string('numerocta')->nullable();
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
        Schema::dropIfExists('cuentas');
    }
}
