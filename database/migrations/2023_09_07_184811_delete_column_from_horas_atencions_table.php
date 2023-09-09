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
        Schema::table('horas_atencions', function (Blueprint $table) {
            $table->dropForeign(['dia_atencion_id']);
            $table->dropColumn('dia_atencion_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('horas_atencions', function (Blueprint $table) {
            //
        });
    }
};
