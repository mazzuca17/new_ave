<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('curso_id');
            $table->unsignedBigInteger('school_id');

            $table->string('image_profile')->nullable();
            $table->enum('condition', ['aprobado', 'finales']);
            $table->double('promedio_general');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id') // permission id
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('curso_id')
                ->references('id') // permission id
                ->on('cursos')
                ->onDelete('cascade');

            $table->foreign('school_id')
                ->references('id') // permission id
                ->on('schools')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
