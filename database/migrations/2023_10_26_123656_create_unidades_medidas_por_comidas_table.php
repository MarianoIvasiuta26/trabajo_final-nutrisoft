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
        Schema::create('unidades_medidas_por_comidas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_unidad_medida', 25)->default('Sin unidad de medida'); //Gramos, kcal, plato, taza etc.
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
        Schema::dropIfExists('unidades_medidas_por_comidas');
    }
};
