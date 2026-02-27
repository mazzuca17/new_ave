<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectActivitiesTable extends Migration
{
    public function up()
    {
        Schema::create('subject_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_course_id');
            $table->string('title');
            $table->text('instructions')->nullable();
            $table->date('due_date')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subject_activities');
    }
}
