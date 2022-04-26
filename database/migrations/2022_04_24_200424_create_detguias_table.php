<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetguiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detguias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('guia_id');
            $table->unsignedBigInteger('producto_id');
            $table->decimal('cantidad',10,2);
            $table->string('adicional')->nullable();
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
        Schema::dropIfExists('detguias');
    }
}
