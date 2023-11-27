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
        Schema::table('detalles_planes_seguimientos', function (Blueprint $table) {
            $table->unsignedBigInteger('act_rec_id')->after('plan_de_seguimiento_id');
            $table->foreign('act_rec_id')->references('id')->on('actividad_rec_por_tipo_actividades')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalles_planes_seguimientos', function (Blueprint $table) {
            $table->dropForeign(['act_rec_id']);
            $table->dropColumn('act_rec_id');
        });
    }
};
