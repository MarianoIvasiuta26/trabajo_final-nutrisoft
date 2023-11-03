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
        Schema::create('alimentos_prohibidos_intolerancias', function (Blueprint $table) {
            $table->id();
            $intoleranciaId = DB::table('intolerancias')->where('intolerancia', 'Ninguna')->value('id');
            $table->unsignedBigInteger('intolerancia_id')->default($intoleranciaId);
            $table->foreign('intolerancia_id')->references('id')->on('intolerancias')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('alimentos_prohibidos_intolerancias');
    }
};
