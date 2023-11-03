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
        Schema::create('alimentos_prohibidos_patologias', function (Blueprint $table) {
            $table->id();
            $patologiaId = DB::table('patologias')->where('patologia', 'Ninguna')->value('id');
            $table->unsignedBigInteger('patologia_id')->default($patologiaId);
            $table->foreign('patologia_id')->references('id')->on('patologias')->onDelete('cascade')->onUpdate('cascade');
            $alimentoId = DB::table('alimentos')->where('alimento', 'Sin Alimento')->value('id');
            $table->unsignedBigInteger('alimento_id')->default($alimentoId);
            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('alimentos_prohibidos_patologias');
    }
};
