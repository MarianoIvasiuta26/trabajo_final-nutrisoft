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
        Schema::create('valor_nutricionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alimento_id');
            $table->foreign('alimento_id')->references('id')->on('alimentos');
            $table->string('nombre', 20);
            $table->string('unidad', 10);
            $table->double('valor', 8, 2);
            $table->string('tipo',20);
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
        Schema::dropIfExists('valor_nutricionals');
    }
};
