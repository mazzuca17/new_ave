<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEventos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('user_id')->comment('usuario que crea el evento');
            $table->string('title');
            $table->text('description');
            $table->date('fecha');
            $table->unsignedBigInteger('materia_id')->nullable();
            $table->unsignedBigInteger('curso_id')->nullable();

            $table->foreign('school_id')
                ->references('id') // permission id
                ->on('schools')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id') // permission id
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('materia_id')
                ->references('id') // permission id
                ->on('materias')
                ->onDelete('cascade');

            $table->foreign('curso_id')
                ->references('id') // permission id
                ->on('cursos')
                ->onDelete('cascade');

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
        Schema::dropIfExists('eventos');
    }
}
