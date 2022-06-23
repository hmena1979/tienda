<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDettrazabilidadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dettrazabilidads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trazabilidad_id');
            $table->unsignedBigInteger('mpd_id');
            $table->unsignedTinyInteger('calidad')->default(1); //(1)Exportacion (2)Mercado Nacional
            $table->unsignedTinyInteger('sobrepeso')->default(10);
            $table->unsignedTinyInteger('envase')->default(1); //(1) Saco (2) Block
            $table->unsignedTinyInteger('peso')->default(20);
            $table->string('codigo', 30);
            $table->decimal('precio',12,2)->nullable();
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
        Schema::dropIfExists('dettrazabilidads');
    }
}
