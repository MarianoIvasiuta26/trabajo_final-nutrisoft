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
        Schema::create('horarios_atencions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nutricionista_id')->nullable();
            $table->foreign('nutricionista_id')->references('id')->on('nutricionistas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('dia_atencion_id')->nullable();
            $table->foreign('dia_atencion_id')->references('id')->on('dias_atencions')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('hora_atencion_id')->nullable();
            $table->foreign('hora_atencion_id')->references('id')->on('horas_atencions')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('horarios_atencions');
    }
};
