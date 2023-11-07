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
        Schema::create('registro_alimentos_consumidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_de_seguimiento_id');
            $table->foreign('plan_de_seguimiento_id')->references('id')->on('planes_de_seguimientos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('alimento_id');
            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('cascade')->onUpdate('cascade');
            $table->double('cantidad', 8,2);
            $table->string('unidad_medida');
            $table->date('fecha_consumida');
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
        Schema::dropIfExists('registro_alimentos_consumidos');
    }
};
