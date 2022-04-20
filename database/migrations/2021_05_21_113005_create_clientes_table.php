<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->string('tipdoc_id',1);
            $table->string('numdoc', 15);
            $table->string('ape_pat', 30)->nullable();
            $table->string('ape_mat', 30)->nullable();
            $table->string('nombres', 30)->nullable();
            $table->string('razsoc');
            $table->string('nomcomercial')->nullable();
            $table->date('fecnac')->nullable();
            $table->string('sexo_id',1)->nullable();
            $table->string('estciv_id',1)->nullable();
            $table->string('direccion', 150)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('celular', 20)->nullable();
            $table->string('email')->nullable(); 
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
        Schema::dropIfExists('clientes');
    }
}
