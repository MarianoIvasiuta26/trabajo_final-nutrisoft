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
        Schema::table('alergias', function (Blueprint $table) {
            $table->dropColumn('alimentos_prohibidos');
            $table->string('grupo_alergia')->after('alergia');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('alergias', function (Blueprint $table) {
            $table->string('alimentos_prohibidos')->after('alergia');
            $table->dropColumn('grupo_alergia');
        });
    }
};
