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
        Schema::create('turnos_temporales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('turno_id_cancelado'); //Id del turno cancelado
            $table->foreign('turno_id_cancelado')->references('id')->on('turnos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('turno_id_adelantado'); //Id del turno adelantado
            $table->foreign('turno_id_adelantado')->references('id')->on('turnos')->onDelete('cascade')->onUpdate('cascade');
            $table->boolean('confirmado')->default(false);
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
        Schema::dropIfExists('turnos_temporales');
    }
};
