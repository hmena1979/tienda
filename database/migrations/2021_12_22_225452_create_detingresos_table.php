<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetingresosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detingresos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rcompra_id');
            $table->unsignedBigInteger('producto_id');
            $table->decimal('cantidad',10,4);
            $table->unsignedTinyInteger('igv')->default(1);
            $table->decimal('pre_ini',12,4);
            $table->decimal('precio',12,4);
            $table->decimal('subtotal',12,2);
            $table->string('lote',15)->nullable();
            $table->string('vence',10)->nullable();
            $table->string('glosa')->nullable();
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
        Schema::dropIfExists('detingresos');
    }
}
