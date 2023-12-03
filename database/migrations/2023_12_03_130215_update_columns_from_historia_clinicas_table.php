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
            $table->double('peso', 8, 2)->default(0)->change()->after('paciente_id');
            $table->double('altura', 8, 2)->default(0)->change()->after('peso');
            $table->double('circunferencia_munieca')->default(0)->change()->after('altura');
            $table->double('circunferencia_cadera')->default(0)->change()->after('circunferencia_munieca');
            $table->double('circunferencia_cintura')->default(0)->change()->after('circunferencia_cadera');
            $table->double('circunferencia_pecho')->default(0)->change()->after('circunferencia_cintura');
            $table->string('estilo_vida',25)->default('Sin estilo de vida')->change()->after('circunferencia_pecho');
            $table->string('objetivo_salud',25)->default('Sin objetivo de salud')->change()->after('estilo_vida');
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

        });
    }
};
