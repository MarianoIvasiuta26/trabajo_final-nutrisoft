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
        Schema::create('dias_atencions', function (Blueprint $table) {
            $table->id();
            $table->string('dia')->nullable();
            $table->unsignedBigInteger('nutricionista_id');
            $table->foreign('nutricionista_id')->references('id')->on('nutricionistas')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dias_atencions');
    }
};
