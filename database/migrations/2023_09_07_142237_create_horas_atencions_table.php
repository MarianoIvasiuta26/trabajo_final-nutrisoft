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
        Schema::create('horas_atencions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dia_atencion_id')->nullable();
            $table->foreign('dia_atencion_id')->references('id')->on('dias_atencions')->onDelete('cascade')->onUpdate('cascade');
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->string('etiqueta', 10)->nullable();
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
        Schema::dropIfExists('horas_atencions');
    }
};
