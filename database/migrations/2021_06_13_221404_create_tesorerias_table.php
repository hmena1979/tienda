<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTesoreriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tesorerias', function (Blueprint $table) {
            $table->id();
            $table->integer('empresa_id')->default(1);
            $table->integer('sede_id')->default(1);
            $table->string('periodo',6);
            // $table->foreignId('cuenta_id')->nullable()->constrained()->onupdate()->ondelete('set null');
            $table->unsignedBigInteger('cuenta_id')->nullable();
            $table->unsignedTinyInteger('tipo')->default(2);//(1)Abono / (2) Cargo
            $table->unsignedTinyInteger('edit')->default(1);//(1)Si / (2) No
            $table->date('fecha');
            $table->decimal('tc',10,3)->nullable();
            $table->string('mediopago',3)->nullable();
            $table->string('numerooperacion',15)->nullable();
            $table->string('notaegreso',10)->nullable();
            $table->decimal('monto',12,2)->nullable();
            $table->string('glosa');
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
        Schema::dropIfExists('tesorerias');
    }
}
