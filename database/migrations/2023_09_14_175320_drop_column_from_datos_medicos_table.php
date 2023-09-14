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
        Schema::table('datos_medicos', function (Blueprint $table) {
            $table->dropForeign(['cirugia_id']);
            $table->dropColumn('cirugia_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datos_medicos', function (Blueprint $table) {
            $table->unsignedBigInteger('cirugia_id');
            $table->foreign('cirugia_id')->references('id')->on('cirugias');
        });
    }
};
