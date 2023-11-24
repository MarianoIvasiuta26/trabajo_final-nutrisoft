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
        Schema::table('detalles_planes_seguimientos', function (Blueprint $table) {
            $table->string('usuario', 80)->after('peso_ideal')->default('Sistema');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detalles_planes_seguimientos', function (Blueprint $table) {
            //
        });
    }
};
