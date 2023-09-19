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
        Schema::create('nutrientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_nutriente_id');
            $table->foreign('tipo_nutriente_id')->references('id')->on('tipo_nutrientes');
            $table->string('nombre_nutriente', 50);
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
        Schema::dropIfExists('nutrientes');
    }
};
