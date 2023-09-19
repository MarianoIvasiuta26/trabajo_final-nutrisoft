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
        Schema::table('valor_nutricionals', function (Blueprint $table) {
            $table->unsignedBigInteger('nutriente_id')->after('fuente_alimento_id');
            $table->foreign('nutriente_id')->references('id')->on('nutrientes');
            $table->dropColumn('tipo');
            $table->dropColumn('nombre');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('valor_nutricionals', function (Blueprint $table) {
            $table->dropForeign(['nutriente_id']);
            $table->dropColumn('nutriente_id');
            $table->string('tipo', 20)->after('fuente_alimento_id');
            $table->string('nombre', 50)->after('tipo');
        });
    }
};
