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
        Schema::create('alimento_por_tipo_de_dietas', function (Blueprint $table) {
            $table->id();
            $alimentoId = DB::table('alimentos')->where('alimento', 'Sin Alimento')->value('id');
            $table->unsignedBigInteger('alimento_id')->default($alimentoId);
            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('cascade')->onUpdate('cascade');
            $dietaId = DB::table('tipos_de_dietas')->where('tipo_de_dieta', 'Sin dieta')->value('id');
            $table->unsignedBigInteger('tipo_de_dieta_id')->default($dietaId);
            $table->foreign('tipo_de_dieta_id')->references('id')->on('tipos_de_dietas')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('alimento_por_tipo_de_dietas');
    }
};
