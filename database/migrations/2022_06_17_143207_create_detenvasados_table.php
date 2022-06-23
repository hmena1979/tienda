<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetenvasadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detenvasados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('envasado_id');
            $table->unsignedBigInteger('dettrazabilidad_id');
            $table->integer('peso')->default(10);
            $table->integer('cantidad');
            $table->integer('total');
            $table->unsignedBigInteger('equipoenvasado_id')->nullable();
            $table->time('hora')->nullable();
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
        Schema::dropIfExists('detenvasados');
    }
}
