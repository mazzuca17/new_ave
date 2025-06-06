<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SubjectTeacher extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_teacher', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_courses_id');
            $table->unsignedBigInteger('teacher_id');
            // $table->foreign('teacher_id')
            //     ->references('id') // permission id
            //     ->on('profesors')
            //     ->onDelete('cascade');
            // $table->foreign('subject_courses_id')
            //     ->references('id') // permission id
            //     ->on('subject_courses')
            //     ->onDelete('cascade');
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
        Schema::dropIfExists('subject_teacher');
    }
}
