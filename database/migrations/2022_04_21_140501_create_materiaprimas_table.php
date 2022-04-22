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
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('transportista_id');
            $table->unsignedBigInteger('chofer_id');
            $table->unsignedBigInteger('camara_id');
            $table->unsignedBigInteger('empacopiadora_id');
            $table->unsignedBigInteger('acopiador_id');
            $table->unsignedBigInteger('embarcacion_id');
            $table->string('lote',15);
            $table->string('guia',15);
            $table->integer('cajas');
            $table->decimal('pplanta', 12, 2);
            $table->date('fpartida');
            $table->date('fllegada');
            $table->date('ingplanta');
            $table->time('hdescarga');
            $table->decimal('precio', 10, 2);
            $table->string('lugar',20)->default('PAITA');
            $table->unsignedBigInteger('producto_id');
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
