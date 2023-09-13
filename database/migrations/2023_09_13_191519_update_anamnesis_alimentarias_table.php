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
        Schema::table('anamnesis_alimentarias', function (Blueprint $table) {
            $table->unsignedBigInteger('historia_clinica_id')->after('id');
            $table->foreign('historia_clinica_id')->references('id')->on('historia_clinicas')->onDelete('cascade');
            $table->dropColumn('alimentos_que_gustan');
            $table->dropColumn('alimentos_que_no_gustan');
            $table->unsignedBigInteger('alimento_id');
            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('cascade');
            $table->boolean('gusta')->after('alimento_id')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anamnesis_alimentarias', function (Blueprint $table) {

        });
    }
};
