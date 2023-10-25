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
        Schema::table('tratamientos', function (Blueprint $table) {
            $table->unsignedBigInteger('tipo_de_dieta_id')->after('tratamiento')->default(1);
            $table->foreign('tipo_de_dieta_id')->references('id')->on('tipos_de_dietas')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tratamientos', function (Blueprint $table) {
            $table->dropForeign(['tipo_de_dieta_id']);
            $table->dropColumn('tipo_de_dieta_id');
        });
    }
};
