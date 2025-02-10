<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotasMaterias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas_materias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('materia_id');
            $table->decimal('score');
            $table->enum('trimestre', ['1', '2', '3']);
            $table->timestamps();

            $table->foreign('student_id')
                ->references('id') // permission id
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('materia_id')
                ->references('id') // permission id
                ->on('materias')
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
        Schema::dropIfExists('notas_materias');
    }
}
