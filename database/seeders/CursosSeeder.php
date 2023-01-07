<?php

namespace Database\Seeders;

use App\Models\Cursos;
use Illuminate\Database\Seeder;
use Database\Factories\CursosFactory;

class CursosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cursos::factory()->count(10)->create();
    }
}
