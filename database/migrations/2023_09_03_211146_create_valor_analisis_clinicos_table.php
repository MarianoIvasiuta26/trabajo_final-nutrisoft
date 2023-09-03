<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valor_analisis_clinicos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('historia_clinica_id')->unique();
            $table->foreign('historia_clinica_id')->references('id')->on('historia_clinicas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('tipo',20)->nullable();
            $table->string('clase',25)->nullable();
            $table->string('nombre_valor',25)->nullable();
            $table->string('medida',15)->nullable();
            $table->double('rango_valor1',8,2)->nullable();
            $table->double('rango_valor2',8,2)->nullable();
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
        Schema::dropIfExists('valor_analisis_clinicos');
    }
};
