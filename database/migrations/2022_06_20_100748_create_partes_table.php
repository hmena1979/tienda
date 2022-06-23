<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('partes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empresa_id')->default(1);
            $table->string('periodo',6);
            $table->string('lote',15);
            $table->date('recepcion');
            $table->date('congelacion');
            $table->date('empaque');
            $table->date('vencimiento');
            $table->unsignedTinyInteger('produccion')->default(1); //(1) Propia (2)Por Encargo
            $table->unsignedBigInteger('contrata_id');
            $table->unsignedInteger('hombres')->nullable();
            $table->unsignedInteger('mujeres')->nullable();
            $table->string('trazabilidad',20)->nullable();
            $table->unsignedTinyInteger('turno')->default(1); //(1) Dia (2)Noche
            $table->decimal('materiaprima',12,2)->nullable();
            $table->decimal('costomateriaprima',12,2)->nullable();
            $table->decimal('envasado',12,2)->nullable();
            $table->unsignedInteger('sacos')->nullable();
            $table->unsignedInteger('blocks')->nullable();
            $table->decimal('sobrepeso',12,2)->nullable();
            $table->decimal('residuos',12,2)->nullable();
            $table->decimal('costoresiduos',12,2)->nullable();
            $table->decimal('descarte',12,2)->nullable();
            $table->decimal('merma',12,2)->nullable();
            $table->decimal('manoobra',12,2)->nullable();
            $table->decimal('costoproductos',12,2)->nullable();

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
        Schema::dropIfExists('partes');
    }
}
