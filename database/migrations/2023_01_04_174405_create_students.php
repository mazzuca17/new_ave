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

            // Datos personales
            $table->string('dni')->unique();
            $table->date('fecha_nacimiento')->nullable();
            $table->enum('genero', ['masculino', 'femenino', 'otro'])->nullable();
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('nacionalidad')->nullable();
            $table->string('image_profile')->nullable();

            // Datos académicos
            $table->year('anio_ingreso')->nullable();
            $table->decimal('promedio', 5, 2)->nullable();
            $table->enum('condition', ['aprobado', 'finales', 'regular']);

            // Datos administrativos
            $table->enum('estado_matricula', ['inscrito', 'preinscrito', 'baja', 'egresado'])->default('inscrito');
            $table->boolean('beca')->default(false);

            // Datos familiares
            $table->string('nombre_tutor')->nullable();
            $table->string('telefono_tutor')->nullable();

            // Datos médicos
            $table->text('alergias')->nullable();
            $table->string('seguro_medico')->nullable();
            $table->string('contacto_emergencia')->nullable();

            $table->timestamps();

            // Claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
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
