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
            $table->dropForeign('tratamientos_tipo_actividad_id_foreign');
            $table->dropColumn('tipo_actividad_id');
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
            $table->unsignedBigInteger('tipo_actividad_id');
            $table->foreign('tipo_actividad_id')->references('id')->on('tipos_de_actividades')->onDelete('cascade')->onUpdate('cascade');
        });
    }
};
