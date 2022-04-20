<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDettesorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dettesors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dettesorable_id');
            $table->string('dettesorable_type');
            // $table->foreignId('tesoreria_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('tesoreria_id');
            $table->decimal('montopen',12,2)->nullable();
            $table->decimal('montousd',12,2)->nullable();
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
        Schema::dropIfExists('dettesors');
    }
}
