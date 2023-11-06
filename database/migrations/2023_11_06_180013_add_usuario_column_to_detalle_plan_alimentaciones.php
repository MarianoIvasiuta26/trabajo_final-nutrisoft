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
        Schema::table('detalle_plan_alimentaciones', function (Blueprint $table) {
            $table->string('usuario', 80)->after('observacion')->default('Sistema');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalle_plan_alimentaciones', function (Blueprint $table) {
            //
        });
    }
};
