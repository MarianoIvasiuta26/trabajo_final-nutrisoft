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
        Schema::create('alimentos_recomendados_por_dietas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alimento_por_dieta_id');
            $table->foreign('alimento_por_dieta_id')->references('id')->on('alimento_por_tipo_de_dietas')->onDelete('cascade')->onUpdate('cascade');
            $comidaId = DB::table('comidas')->where('nombre_comida', 'Sin comida')->value('id');
            $table->unsignedBigInteger('comida_id')->default($comidaId);
            $table->foreign('comida_id')->references('id')->on('comidas')->onDelete('cascade')->onUpdate('cascade');
            $table->decimal('cantidad', 5,2)->default(0);
            $unidadMedidaId = DB::table('unidades_medidas_por_comidas')->where('nombre_unidad_medida', 'Sin unidad de medida')->value('id');
            $table->unsignedBigInteger('unidad_medida_id')->default($unidadMedidaId);
            $table->foreign('unidad_medida_id')->references('id')->on('unidades_medidas_por_comidas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('alimentos_recomendados_por_dietas');
    }
};
