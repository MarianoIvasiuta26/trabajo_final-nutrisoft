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
        Schema::create('alimentos_prohibidos_alergias', function (Blueprint $table) {
            $table->id();
            $alergiaId = DB::table('alergias')->where('alergia', 'Ninguna')->value('id');
            $table->unsignedBigInteger('alergia_id')->default($alergiaId);
            $table->foreign('alergia_id')->references('id')->on('alergias')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('alimentos_prohibidos_alergias');
    }
};
