<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CursosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'school_id'  => 1,
            'name'       =>  rand(1, 7) . '° ' . $this->faker->randomElement($this->getStringCurses()) . ' ' . $this->faker->randomElement($this->getTypeCurse()),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

        ];
    }

    /**
     * getStringCurses
     *
     * @return array
     */
    public function getStringCurses(): array
    {
        return range('A', 'G');
    }

    /**
     * getTypeCurse
     *
     * @return array 
     */
    public function getTypeCurse(): array
    {
        return ['Informática', 'Electrónica', 'Técnico', 'Bachiller', 'Economía', 'Naturales', 'Arte'];
    }
}
