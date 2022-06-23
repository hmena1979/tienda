<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEquipoenvasadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('equipoenvasados', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->string('nombre',100);
            $table->unsignedTinyInteger('activo')->default(1);
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
        Schema::dropIfExists('equipoenvasados');
    }
}
