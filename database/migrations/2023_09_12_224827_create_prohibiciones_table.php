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
        Schema::create('prohibiciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alergia_id');
            $table->foreign('alergia_id')->references('id')->on('alergias');
            $table->unsignedBigInteger('patologia_id');
            $table->foreign('patologia_id')->references('id')->on('patologias');
            $table->unsignedBigInteger('cirugia_id');
            $table->foreign('cirugia_id')->references('id')->on('cirugias');
            $table->unsignedBigInteger('intolerancia_id');
            $table->foreign('intolerancia_id')->references('id')->on('intolerancias');
            $table->unsignedBigInteger('valor_analisis_clinico_id');
            $table->foreign('valor_analisis_clinico_id')->references('id')->on('valor_analisis_clinicos');
            $table->unsignedBigInteger('alimento_id');
            $table->foreign('alimento_id')->references('id')->on('alimentos');
            $table->unsignedBigInteger('actividad_id');
            $table->foreign('actividad_id')->references('id')->on('actividades');
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
        Schema::dropIfExists('prohibiciones');
    }
};
