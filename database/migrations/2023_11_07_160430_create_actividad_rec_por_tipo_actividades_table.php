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
        Schema::create('actividad_rec_por_tipo_actividades', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('act_tipoAct_id');
            $table->foreign('act_tipoAct_id')->references('id')->on('actividades_por_tipos_de_actividades')->onDelete('cascade')->onUpdate('cascade');
            $table->integer('duracion_actividad')->default(0);
            $table->unsignedBigInteger('unidad_tiempo_id')->default(1);
            $table->foreign('unidad_tiempo_id')->references('id')->on('unidades_de_tiempos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('actividad_rec_por_tipo_actividades');
    }
};
