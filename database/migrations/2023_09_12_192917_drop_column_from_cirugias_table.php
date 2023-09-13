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
        Schema::table('cirugias', function (Blueprint $table) {
            $table->dropColumn('alimentos_prohibidos');
            $table->dropColumn('actividades_prohibidas');
            $table->string('grupo_cirugia', 25)->after('cirugia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cirugias', function (Blueprint $table) {
            $table->string('alimentos_prohibidos', 25)->after('cirugia');
            $table->string('actividades_prohibidas', 25)->after('alimentos_prohibidos');
            $table->dropColumn('grupo_cirugia');
        });
    }
};
