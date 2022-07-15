<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetsolcomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detsolcompras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('solcompra_id');
            $table->unsignedBigInteger('producto_id');
            $table->decimal('solicitado',10,4);
            $table->decimal('cantidad',10,4);
            $table->decimal('atendido',10,4);
            $table->unsignedTinyInteger('estado')->default(1); //(1)Pendiente (2)Atendido) (3)Rechazado
            $table->string('pedidos',100)->nullable();
            $table->string('glosa',100)->nullable();

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
        Schema::dropIfExists('detsolcompras');
    }
}
