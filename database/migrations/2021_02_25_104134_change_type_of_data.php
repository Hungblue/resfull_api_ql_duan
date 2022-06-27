<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeOfData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('estimations', function (Blueprint $table) {
            $table->float('effort', 12, 3)->change();
            $table->float('unit_price', 12, 3)->nullable()->change();
            $table->float('total', 12, 3)->nullable()->change();
        });

        Schema::table('projects', function (Blueprint $table) {
            $table->float('unit_price', 12, 3)->nullable()->change();
            $table->float('size', 12, 3)->nullable()->change();
        });

        Schema::table('resources', function (Blueprint $table) {
            $table->integer('busy_rate')->nullable()->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->integer('busy_rate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('estimations', function (Blueprint $table) {
            //
        });
    }
}
