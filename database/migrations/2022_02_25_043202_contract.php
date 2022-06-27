<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Contract extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('type_contract');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->float('basic_salary', 15,0)->nullable();
            $table->string('salary_rank')->nullable();
            $table->float('salary', 15, 0)->nullable();
            $table->float('salary_allowance', 15, 0)->nullable();
            $table->integer('type_allowance')->nullable();
            $table->integer('position');
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
        Schema::dropIfExists('contract');
    }
}
