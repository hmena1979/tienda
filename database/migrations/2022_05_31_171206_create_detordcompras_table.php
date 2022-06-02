<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetordcomprasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detordcompras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ordcompra_id');
            $table->unsignedBigInteger('producto_id');
            $table->decimal('cantidad',10,4);
            $table->decimal('precio',12,4);
            $table->decimal('subtotal',12,2);
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
        Schema::dropIfExists('detordcompras');
    }
}
