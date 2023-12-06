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
        Schema::create('recetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_receta')->default('Sin receta');
            $table->integer('tiempo_preparacion')->default(0);
            $table->double('porciones', 8,2)->default(0);
            $unidadID = DB::table('unidades_de_tiempos')
            ->where('nombre_unidad_tiempo', 'Sin unidad de tiempo')
            ->value('id');
            $table->unsignedBigInteger('unidad_de_tiempo_id')->default($unidadID);
            $table->foreign('unidad_de_tiempo_id')->references('id')->on('unidades_de_tiempos')->onDelete('cascade')->onUpdate('cascade')->onDelete('cascade')->onUpdate('cascade');
            $table->string('recursos_externos')->default('Sin recursos externos');
            $table->string('preparacion')->default('Sin preparación');
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
        Schema::dropIfExists('recetas');
    }
};
