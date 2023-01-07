<?php

namespace Database\Seeders;

use App\Models\Materias;
use Database\Factories\MateriasFactory;
use Illuminate\Database\Seeder;

class MateriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Materias::factory()->count(10)->create();
    }
}
