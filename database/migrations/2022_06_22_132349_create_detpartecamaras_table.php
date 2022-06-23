<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetpartecamarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detpartecamaras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parte_id');
            $table->unsignedBigInteger('trazabilidad_id');
            $table->unsignedBigInteger('dettrazabilidad_id');
            $table->decimal('sobrepeso',12,2)->nullable();
            $table->integer('sacos');
            $table->integer('blocks');
            $table->integer('total')->nullable();
            $table->decimal('parcial',12,2)->nullable();
            $table->decimal('costo',12,2)->nullable();
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
        Schema::dropIfExists('detpartecamaras');
    }
}
