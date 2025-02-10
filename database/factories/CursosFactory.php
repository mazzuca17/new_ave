<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cursos;

class CursosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $uniqueName = $this->generateUniqueName();

        return [
            'school_id'  => 1,
            'name'       => $uniqueName,
            'modalidad'  => $this->faker->randomElement($this->getTypeCurse()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    /**
     * Genera un nombre único para el curso
     *
     * @return string
     */
    private function generateUniqueName(): string
    {
        do {
            $name = rand(1, 7) . '° ' . $this->faker->randomElement($this->getStringCurses());
        } while (Cursos::where('name', $name)->exists());

        return $name;
    }

    /**
     * Devuelve los nombres de los cursos disponibles
     *
     * @return array
     */
    public function getStringCurses(): array
    {
        return range('A', 'G');
    }

    /**
     * Devuelve los tipos de curso disponibles
     *
     * @return array 
     */
    public function getTypeCurse(): array
    {
        return ['Informática', 'Electrónica', 'Técnico', 'Bachiller', 'Economía', 'Naturales', 'Arte'];
    }
}
