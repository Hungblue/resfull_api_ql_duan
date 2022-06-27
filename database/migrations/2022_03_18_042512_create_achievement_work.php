<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAchievementWork extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('achievement_work', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('check_point_id');
            $table->integer('project_id');
            $table->bigInteger('user_id');
            $table->string('participation_time');
            $table->string('work_name');
            $table->float('result_user', 5, 0)->nullable();
            $table->float('result_leader', 5, 0)->nullable();
            $table->longText('comment')->nullable();
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
        Schema::dropIfExists('achievement_work');
    }
}
