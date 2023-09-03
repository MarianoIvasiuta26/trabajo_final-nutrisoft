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
        Schema::create('cirugias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('historia_clinica_id')->unique();
            $table->foreign('historia_clinica_id')->references('id')->on('historia_clinicas')->onDelete('cascade')->onUpdate('cascade');
            $table->string('cirugia',50)->nullable();
            $table->string('alimentos_prohibidos',25)->nullable();
            $table->string('actividades_prohibidas',25)->nullable();
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
        Schema::dropIfExists('cirugias');
    }
};
