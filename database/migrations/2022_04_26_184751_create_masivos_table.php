<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('masivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->unsignedBigInteger('sede_id')->default(1);
            $table->string('periodo',6);
            $table->date('fecha');
            $table->decimal('tc',10,3)->nullable();
            $table->unsignedBigInteger('cuenta_id')->nullable();
            $table->decimal('monto',12,2)->nullable();
            $table->unsignedTinyInteger('estado')->default(1); //(1)Pendiente (2)Aprobado (3)Generado
            $table->string('glosa');
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
        Schema::dropIfExists('masivos');
    }
}
