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
        Schema::create('mediciones_de_pliegues_cutaneos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('historia_clinica_id');
            $table->foreign('historia_clinica_id')->references('id')->on('historia_clinicas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('consulta_id');
            $table->foreign('consulta_id')->references('id')->on('consultas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('pliegue_id');
            $table->foreign('pliegue_id')->references('id')->on('tipos_de_pliegue_cutaneos')->onDelete('cascade')->onUpdate('cascade');
            $table->double('valor_medicion', 8, 2)->default(0.00);
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
        Schema::dropIfExists('mediciones_de_pliegues_cutaneos');
    }
};
