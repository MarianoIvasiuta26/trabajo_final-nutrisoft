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
        Schema::create('tipos_actividades_por_tratamientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tratamiento_id');
            $table->unsignedBigInteger('tipo_actividad_id');
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('tipo_actividad_id')->references('id')->on('tipos_de_actividades')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('tipos_actividades_por_tratamientos');
    }
};
