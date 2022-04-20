<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetproductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detproductos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->integer('sede_id')->default(1);
            $table->unsignedBigInteger('marca_id')->default(1);
            $table->unsignedBigInteger('talla_id')->default(1);
            $table->unsignedBigInteger('color_id')->default(1);
            $table->unsignedTinyInteger('afecto')->default(1);
            $table->unsignedTinyInteger('lotevencimiento')->default(2);
            $table->unsignedTinyInteger('ctrlstock')->default(1);
            $table->decimal('stock',12,4)->nullable();
            $table->decimal('stockmin',12,2)->nullable();
            $table->decimal('precompra',12,4)->nullable();
            $table->decimal('preventamin',10,4)->nullable();
            $table->decimal('preventa',10,4)->nullable();
            $table->decimal('porganancia',10,2)->nullable();
            $table->string('codigo',9); // grupo(1) + ID Producto(00000008)
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
        Schema::dropIfExists('detproductos');
    }
}
