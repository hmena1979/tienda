<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIngcamarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ingcamaras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->string('periodo',6);
            $table->date('fecha');
            $table->date('fproduccion');
            $table->string('lote',15);
            $table->string('numero',6);
            $table->unsignedBigInteger('supervisor_id');
            $table->unsignedBigInteger('parte_id')->nullable();
            $table->unsignedTinyInteger('estado')->default(1); //(1) Pendiente (2)Autorizado
            $table->unsignedBigInteger('user_id')->nullable();
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
        Schema::dropIfExists('ingcamaras');
    }
}
