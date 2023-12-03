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
        Schema::table('historia_clinicas', function (Blueprint $table) {
            $table->double('peso', 8, 2)->nullable(false)->change();
            $table->double('altura', 8, 2)->nullable(false)->change();
            $table->double('circunferencia_munieca')->nullable(false)->change();
            $table->double('circunferencia_cadera')->nullable(false)->change();
            $table->double('circunferencia_cintura')->nullable(false)->change();
            $table->double('circunferencia_pecho')->nullable(false)->change();
            $table->string('estilo_vida', 25)->nullable(false)->change();
            $table->string('objetivo_salud', 25)->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('historia_clinicas', function (Blueprint $table) {
            $table->double('peso', 8, 2)->nullable()->change();
            $table->double('altura', 8, 2)->nullable()->change();
            $table->double('circunferencia_munieca')->nullable()->change();
            $table->double('circunferencia_cadera')->nullable()->change();
            $table->double('circunferencia_cintura')->nullable()->change();
            $table->double('circunferencia_pecho')->nullable()->change();
            $table->string('estilo_vida', 25)->nullable()->change();
            $table->string('objetivo_salud', 25)->nullable()->change();
        });
    }
};
