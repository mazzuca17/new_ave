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
            $table->unsignedBigInteger('materia_id');
            $table->unsignedBigInteger('curso_id');
            $table->enum('day', ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado']);
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();

            $table->foreign('materia_id')
                ->references('id') // permission id
                ->on('materias')
                ->onDelete('cascade');

            $table->foreign('curso_id')
                ->references('id') // permission id
                ->on('cursos')
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
        Schema::dropIfExists('subject_schedules');
    }
}
