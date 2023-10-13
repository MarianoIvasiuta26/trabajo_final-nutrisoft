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
        Schema::create('detalle_plan_alimentaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plan_alimentacion_id');
            $table->foreign('plan_alimentacion_id')->references('id')->on('plan_alimentaciones')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('alimento_id');
            $table->foreign('alimento_id')->references('id')->on('alimentos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('horario_consumicion', 80)->default('Sin horario');
            $table->double('cantidad', 8, 2)->default(0);
            $table->string('unidad_medida', 50)->default('Sin unidad de medida');
            $table->string('observacion', 255)->default('Sin observación');
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
        Schema::dropIfExists('detalle_plan_alimentaciones');
    }
};
