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
        Schema::table('intolerancias', function (Blueprint $table) {
            $table->dropColumn('alimentos_prohibidos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('intolerancias', function (Blueprint $table) {
            $table->string('alimentos_prohibidos', 25)->after('intolerancia');
        });
    }
};
