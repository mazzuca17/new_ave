<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

class MateriasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $curso = rand(1, 7);
        return [
            'school_id'    => 1,
            'curso_id'     => $curso,
            'code_materia' => '1' . $curso,
            'nombre'       => $this->faker->randomElement($this->createNameMateria(intval($curso))),
            'created_at'   => Carbon::now(),
            'updated_at'   => Carbon::now(),
        ];
    }

    /**
     * createNameMateria
     *
     * @param [type] $curso
     * @author Matías
     */
    public function createNameMateria($curso)
    {
        return ['Matemática', 'Geografía', 'Ciencas Naturales', 'Física', 'Lengua'];
    }
}
