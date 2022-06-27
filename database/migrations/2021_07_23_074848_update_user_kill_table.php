<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserKillTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_skill', function (Blueprint $table) {
            $table->integer('time_experience')->nullable()->after('skill_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('time_experience');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_skill', function (Blueprint $table) {
            $table->dropColumn('time_experience');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('time_experience')->nullable()->after('remember_token');
        });
    }
}
