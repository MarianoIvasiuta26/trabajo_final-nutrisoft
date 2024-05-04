<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::table('tags', function (Blueprint $table) {
            Schema::table('tags', function (Blueprint $table) {
                $default = DB::table('grupos_tags')->where('grupo_tag','Sin grupo')->first();
                $defaultId = $default ? $default->id : null;
                $table->unsignedBigInteger('grupo_tag_id')->default($defaultId)->after('name');
                $table->foreign('grupo_tag_id')->references('id')->on('grupos_tags')->onDelete('cascade')->onUpdate('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tags', function (Blueprint $table) {
            Schema::table('tags', function (Blueprint $table) {
                $table->dropForeign(['grupo_tag_id']);
                $table->dropColumn('grupo_tag_id');
            });
        });
    }
};
