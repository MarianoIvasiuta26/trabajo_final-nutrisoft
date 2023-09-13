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
            $table->dropForeign(['historia_clinica_id']);
            $table->dropColumn('historia_clinica_id');
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
            $table->unsignedBigInteger('historia_clinica_id');
            $table->foreign('historia_clinica_id')->references('id')->on('historia_clinicas');
        });
    }
};
