<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryCheckPoint extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_check_point', function (Blueprint $table) {
            $table->id();
            $table->integer('check_point_id');
            $table->bigInteger('contract_id');
            $table->integer('user_id');
            $table->integer('status')->nullable();
            $table->string('status_submit')->nullable();
            $table->float('new_salary', 15, 0)->nullable();
            $table->float('current_salary', 15, 0)->nullable();
            $table->longText('target_previous_period')->nullable();
            $table->longText('target_next_period')->nullable();
            $table->longText('development_expectations')->nullable();
            $table->longText('content')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_check_point');
    }
}
