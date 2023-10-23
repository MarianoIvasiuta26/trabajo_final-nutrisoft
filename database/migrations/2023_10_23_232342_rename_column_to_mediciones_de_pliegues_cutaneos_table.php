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
        Schema::table('mediciones_de_pliegues_cutaneos', function (Blueprint $table) {
            $table->renameColumn('pliegue_id', 'tipos_de_pliegue_cutaneo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mediciones_de_pliegues_cutaneos', function (Blueprint $table) {
            $table->renameColumn('tipos_de_pliegue_cutaneo_id', 'pliegue_id');
        });
    }
};
