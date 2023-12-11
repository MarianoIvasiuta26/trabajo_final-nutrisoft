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
        Schema::table('registro_alimentos_consumidos', function (Blueprint $table) {
            $table->double('kcal', 8,2)->default(0)->after('unidad_medida');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('registro_alimentos_consumidos', function (Blueprint $table) {
            $table->dropColumn('kcal');
        });
    }
};
