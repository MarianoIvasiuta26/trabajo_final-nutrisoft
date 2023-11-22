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
        Schema::create('actividades_prohibidas_cirugias', function (Blueprint $table) {
            $table->id();
            $cirugiaId = DB::table('cirugias')->where('cirugia', 'Ninguna')->value('id');
            $actividadId = DB::table('actividades')->where('actividad', 'Sin Actividades')->value('id');
            $table->unsignedBigInteger('actividad_id')->default($actividadId);
            $table->unsignedBigInteger('cirugia_id')->default($cirugiaId);
            $table->foreign('actividad_id')->references('id')->on('actividades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('cirugia_id')->references('id')->on('cirugias')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('actividades_prohibidas_cirugias');
    }
};
