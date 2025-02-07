<?php

namespace Database\Seeders;

use App\Models\TypeEvent;
use Illuminate\Database\Seeder;

class TypeEventosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Se usa el método create con un arreglo de múltiples registros
        TypeEvent::insert([
            [
                'name' => 'administrativo',
                'code_color' => '#FF5733' // Código de color para administrativo
            ],
            [
                'name' => 'global',
                'code_color' => '#33FF57' // Código de color para global
            ],
            [
                'name' => 'evaluación',
                'code_color' => '#3357FF' // Código de color para evaluación
            ],
            [
                'name' => 'entrega_tp',
                'code_color' => '#FF33A6' // Código de color para entrega_tp
            ]
        ]);
    }
}
