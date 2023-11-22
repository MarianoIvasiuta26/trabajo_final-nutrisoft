<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('actividades_prohibidas_patologias', function (Blueprint $table) {
            $table->id();
            $patologiaId = DB::table('patologias')->where('patologia', 'Ninguna')->value('id');
            $actividadId = DB::table('actividades')->where('actividad', 'Sin Actividades')->value('id');
            $table->unsignedBigInteger('actividad_id')->default($actividadId);
            $table->unsignedBigInteger('patologia_id')->default($patologiaId);
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('patologia_id')->references('id')->on('patologias')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('actividades_prohibidas_patologias');
    }
};
