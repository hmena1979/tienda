<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transferencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->unsignedBigInteger('sede_id')->default(1);
            $table->string('periodo',6);
            $table->date('fecha');
            $table->decimal('tc',10,3)->nullable();
            $table->unsignedBigInteger('cargo_id');
            $table->unsignedBigInteger('abono_id');
            $table->string('mediopago',3)->nullable();
            $table->string('numerooperacion',15)->nullable();
            $table->unsignedBigInteger('cliente_id')->default(3);
            $table->string('glosa')->nullable();
            $table->decimal('montopen',12,2)->nullable();
            $table->decimal('montousd',12,2)->nullable();
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
        Schema::dropIfExists('transferencias');
    }
}
