<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_course_id');
            $table->integer('day_of_week');
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            //$table->foreign('subject_course_id')->references('id')->on('subject_courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subject_schedules');
    }
}
