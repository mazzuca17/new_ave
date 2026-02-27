<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectContentsTable extends Migration
{
    public function up()
    {
        Schema::create('subject_contents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_course_id');
            $table->string('title');
            $table->string('category');
            $table->text('description')->nullable();
            $table->string('link')->nullable();
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('subject_contents');
    }
}
