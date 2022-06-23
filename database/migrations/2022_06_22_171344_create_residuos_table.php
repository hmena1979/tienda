<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResiduosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('residuos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->string('periodo',6);
            $table->string('lote',15);            
            $table->string('especie',30)->default('POTA');            
            $table->unsignedBigInteger('cliente_id');
            $table->string('ticket_balanza',15)->nullable();
            $table->date('emision');
            $table->string('guiamps',15);
            $table->string('guiahl',15);
            $table->string('guiatrasporte',15);
            $table->decimal('peso',12,2)->nullable();
            $table->decimal('precio',12,2)->nullable();
            $table->decimal('total',12,2)->nullable();
            $table->string('placa',10);
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
        Schema::dropIfExists('residuos');
    }
}
