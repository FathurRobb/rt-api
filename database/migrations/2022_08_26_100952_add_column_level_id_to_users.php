<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnLevelIdToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if( !Schema::hasColumn('users', 'level_id') ) {
            Schema::table('users', function (Blueprint $table) {
                $table->unsignedInteger('level_id')->nullable()->after('nik');
                $table->foreign('level_id')->references('id')->on('master_levels');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_level_id_foreign');
            $table->dropColumn('level_id');
        });
    }
}
