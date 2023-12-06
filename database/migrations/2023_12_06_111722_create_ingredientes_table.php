<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('ingredientes', function (Blueprint $table) {
            $table->id();
            $alimentoID = DB::table('alimentos')->where('alimento', 'Sin Alimento')->value('id');
            $table->unsignedBigInteger('alimento_id')->default($alimentoID);
            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('cascade')->onUpdate('cascade');
            $recetaID = DB::table('recetas')->where('nombre_receta', 'Sin receta')->value('id');
            $table->unsignedBigInteger('receta_id')->default($recetaID);
            $table->foreign('receta_id')->references('id')->on('recetas')->onDelete('cascade')->onUpdate('cascade');
            $table->double('cantidad', 8.2)->default(0);
            $unidadID = DB::table('unidades_medidas_por_comidas')->where('nombre_unidad_medida', 'Sin unidad de medida')->value('id');
            $table->unsignedBigInteger('unidad_medida_por_comida_id')->default($unidadID);
            $table->foreign('unidad_medida_por_comida_id')->references('id')->on('unidades_medidas_por_comidas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('ingredientes');
    }
};
