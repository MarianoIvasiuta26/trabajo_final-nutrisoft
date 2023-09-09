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
        Schema::table('nutricionistas', function (Blueprint $table) {
            $table->dropColumn('hora_inicio_maniana');
            $table->dropColumn('hora_fin_maniana');
            $table->dropColumn('hora_inicio_tarde');
            $table->dropColumn('hora_fin_tarde');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nutricionistas', function (Blueprint $table) {
            //
        });
    }
};
