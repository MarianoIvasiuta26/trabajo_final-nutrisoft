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
        Schema::create('actividades_por_tipos_de_actividades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actividad_id')->default(1);
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('tipo_actividad_id')->default(1);
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
        Schema::dropIfExists('actividades_por_tipos_de_actividades');
    }
};
