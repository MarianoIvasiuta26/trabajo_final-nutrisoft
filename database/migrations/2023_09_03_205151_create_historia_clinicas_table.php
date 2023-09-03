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
        Schema::create('historia_clinicas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paciente_id')->unique();
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade')->onUpdate('cascade');
            $table->double('peso', 8, 2)->nullable();
            $table->double('altura', 8, 2)->nullable();
            $table->double('circunferencia_munieca')->nullable();
            $table->double('circunferencia_cadera')->nullable();
            $table->double('circunferencia_cintura')->nullable();
            $table->double('circunferencia_pecho')->nullable();
            $table->string('estilo_vida',25)->nullable();
            $table->string('objetivo_salud',25)->nullable();
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
        Schema::dropIfExists('historia_clinicas');
    }
};
