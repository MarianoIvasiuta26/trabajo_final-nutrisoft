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
        Schema::table('consultas', function (Blueprint $table) {
            $table->decimal('imc_actual', 8,2)->default(0.00)->after('circunferencia_pecho_actual');
            $table->decimal('masa_grasa_actual', 8,2)->default(0.00)->after('imc_actual');
            $table->decimal('masa_muscular_actual', 8,2)->default(0.00)->after('masa_grasa_actual');
            $table->decimal('masa_osea_actual', 8,2)->default(0.00)->after('masa_muscular_actual');
            $table->decimal('masa_residual_actual', 8,2)->default(0.00)->after('masa_osea_actual');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('consultas', function (Blueprint $table) {
            $table->dropColumn('imc_actual');
            $table->dropColumn('masa_grasa_actual');
            $table->dropColumn('masa_muscular_actual');
            $table->dropColumn('masa_osea_actual');
            $table->dropColumn('masa_residual_actual');
        });
    }
};
