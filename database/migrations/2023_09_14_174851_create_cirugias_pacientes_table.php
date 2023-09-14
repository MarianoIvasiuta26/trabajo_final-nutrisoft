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
        Schema::create('cirugias_pacientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('historia_clinica_id');
            $table->foreign('historia_clinica_id')->references('id')->on('historia_clinicas');
            $table->unsignedBigInteger('cirugia_id');
            $table->foreign('cirugia_id')->references('id')->on('cirugias');
            $table->integer('tiempo');
            $table->string('unidad_tiempo', 10);
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
        Schema::dropIfExists('cirugias_pacientes');
    }
};
