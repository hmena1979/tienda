<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetmasivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detmasivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('masivo_id');
            $table->unsignedBigInteger('rcompra_id');
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
        Schema::dropIfExists('detmasivos');
    }
}
