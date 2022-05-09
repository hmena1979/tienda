<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetmateriaprimasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detmateriaprimas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('materiaprima_id')->nullable();
            $table->string('pesada',3);
            $table->decimal('pesobruto',10,2);
            $table->decimal('tara',10,2);
            $table->decimal('pesoneto',10,2);
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
        Schema::dropIfExists('detmateriaprimas');
    }
}
