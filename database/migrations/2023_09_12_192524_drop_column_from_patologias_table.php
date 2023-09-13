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
        Schema::table('patologias', function (Blueprint $table) {
            $table->dropColumn('alimentos_prohibidos');
            $table->dropColumn('actividades_prohibidas');
            $table->string('grupo_patologia', 25)->after('patologia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('patologias', function (Blueprint $table) {
            $table->string('alimentos_prohibidos', 25)->after('patologia');
            $table->string('actividades_prohibidas', 25)->after('alimentos_prohibidos');
            $table->dropColumn('grupo_patologia');
        });
    }
};
