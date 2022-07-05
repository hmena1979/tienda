<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetdetsalcamarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detdetsalcamaras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('detsalcamara_id');
            $table->unsignedBigInteger('productoterminado_id');
            $table->string('lote',15)->nullable();
            $table->decimal('cantidad')->nullable();
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
        Schema::dropIfExists('detdetsalcamaras');
    }
}
