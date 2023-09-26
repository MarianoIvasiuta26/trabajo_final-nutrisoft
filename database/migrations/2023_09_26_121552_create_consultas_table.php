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
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('turno_id');
            $table->foreign('turno_id')->references('id')->on('turnos')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('nutricionista_id');
            $table->foreign('nutricionista_id')->references('id')->on('nutricionistas')->onDelete('cascade')->onUpdate('cascade')->onUpdate('cascade');
            $table->double('peso_actual',8,2);
            $table->double('altura_actual',8,2);
            $table->double('circunferencia_munieca_actual',8,2);
            $table->double('circunferencia_cintura_actual',8,2);
            $table->double('circunferencia_cadera_actual',8,2);
            $table->double('circunferencia_pecho_actual',8,2);
            $table->string('diagnostico', 255);
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
        Schema::dropIfExists('consultas');
    }
};
