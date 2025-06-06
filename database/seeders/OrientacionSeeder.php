<?php

namespace Database\Seeders;

use App\Models\OrientacionCursos;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class OrientacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrientacionCursos::insert(
            [
                [
                    'name'        => 'Básico',
                    'description' => '',
                    'school_id'   => 1,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ],
                [
                    'name'        => 'Técnico',
                    'description' => '',
                    'school_id'   => 1,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ],
                [
                    'name'        => 'Técnico Informática',
                    'description' => '',
                    'school_id'   => 1,
                    'created_at'  => Carbon::now(),
                    'updated_at'  => Carbon::now()
                ]
            ]
        );
    }
}
