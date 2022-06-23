<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePprocesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pprocesos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->unsignedBigInteger('sede_id')->default(1);
            $table->string('nombre');
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
        Schema::dropIfExists('pprocesos');
    }
}
