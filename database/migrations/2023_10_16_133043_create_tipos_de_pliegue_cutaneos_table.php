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
        Schema::create('tipos_de_pliegue_cutaneos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_pliegue', 100)->default('Sin pliegue cutáneo');
            $table->string('unidad_de_medida', 50)->default('Sin unidad de medida');
            $table->string('descripcion')->default('');
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
        Schema::dropIfExists('tipos_de_pliegue_cutaneos');
    }
};
