<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetingcamarasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detingcamaras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ingcamara_id');
            $table->unsignedBigInteger('dettrazabilidad_id');
            $table->integer('peso')->default(10);
            $table->integer('cantidad');
            $table->integer('total');
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
        Schema::dropIfExists('detingcamaras');
    }
}
