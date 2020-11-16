<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfftimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->time('work_day')->default('8:00');
            $table->time('vacation_allotment')->default('0:00');
            $table->time('personal_time_allotment')->default('0:00');
            $table->time('overtime')->default('0:00');
            $table->time('vacation_carry_over')->default('0:00');
            $table->boolean('use_carry_over')->default(0);
            $table->year('year')->default(\Carbon\Carbon::now()->year);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offtimes');
    }
}
