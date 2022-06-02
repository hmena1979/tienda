<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdcomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordcompras', function (Blueprint $table) {
            $table->id();
            $table->integer('empresa_id')->default(1);
            $table->integer('sede_id')->default(1);
            $table->string('periodo',6);
            $table->date('fecha');
            $table->unsignedBigInteger('cliente_id');
            $table->unsignedBigInteger('detcliente_id')->nullable();
            $table->string('contacto',100)->nullable();
            $table->string('cotizacion',15)->nullable();
            $table->string('moneda',3)->default('PEN');
            $table->decimal('total',12,2)->nullable();
            $table->unsignedTinyInteger('fpago')->default(1);//(1)Contado (2) Credito
            $table->unsignedTinyInteger('dias')->nullable();
            $table->date('vencimiento')->nullable();
            $table->text('observaciones')->nullable();
            $table->unsignedBigInteger('solicitado')->nullable();
            $table->unsignedBigInteger('creado')->nullable();
            $table->unsignedBigInteger('autorizado')->nullable();
            $table->unsignedTinyInteger('estado')->default(1);//(1)En Preparacion (2)Autorizado (3)Enviada
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
        Schema::dropIfExists('ordcompras');
    }
}
