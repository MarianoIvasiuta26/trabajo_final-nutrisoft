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
        Schema::table('users', function (Blueprint $table) {
            $table->string('tipo_usuario')->after('id')->default('paciente');
            $table->string('apellido')->after('name');
            $table->string('telefono')->after('apellido');
            $table->string('dni')->unique()->after('email')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tipo_usuario');
            $table->dropColumn('apellido');
            $table->dropColumn('telefono');
            $table->dropColumn('dni');
        });
    }
};
