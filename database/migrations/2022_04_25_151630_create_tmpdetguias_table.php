<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTmpdetguiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tmpdetguias', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id');
            $table->string('key',10)->nullable();
            $table->unsignedBigInteger('producto_id');
            $table->string('adicional')->nullable();
            $table->decimal('cantidad',10,2);
            $table->string('vence',10)->nullable();
            $table->string('lote',15)->nullable();
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
        Schema::dropIfExists('tmpdetguias');
    }
}
