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
        Schema::create('detalles_planes_seguimientos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_de_seguimiento_id');
            $table->foreign('plan_de_seguimiento_id')->references('id')->on('planes_de_seguimientos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('actividad_id');
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('completada');
            $table->integer('tiempo_realizacion');
            $table->string('unidad_tiempo_realizacion');
            $table->string('recursos_externos');
            $table->string('estado_imc');
            $table->double('peso_ideal', 8,2);
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
        Schema::dropIfExists('detalles_planes_seguimientos');
    }
};
