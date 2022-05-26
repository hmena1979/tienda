<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePedidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pedidos', function (Blueprint $table) {
            $table->id();
            $table->integer('empresa_id')->default(1);
            $table->integer('sede_id')->default(1);
            $table->string('periodo',6);
            $table->date('fecha');
            $table->unsignedTinyInteger('estado')->default(1);//(1) Pendiente (2)Enviada (3)Recepcionada (4)Atendida (5)Rechazado
            $table->text('observaciones')->nullable();
            $table->text('obslogistica')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('detdestino_id')->nullable();
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
        Schema::dropIfExists('pedidos');
    }
}
