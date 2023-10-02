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
        Schema::create('tratamiento_por_pacientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('tratamiento_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->foreign('tratamiento_id')->references('id')->on('tratamientos');
            $table->date('fecha_alta');
            $table->date('fecha_baja')->nullable()->default(null);
            $table->string('observaciones', 255)->nullable()->default('');
            $table->string('estado', 10)->default('Inactivo');
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
        Schema::dropIfExists('tratamiento_por_pacientes');
    }
};
