<?php

namespace Database\Seeders;

use App\Models\EducationalLevels;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EducationalLevelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EducationalLevels::insert([

            [
                'name'        => 'Primario',
                'description' => 'Educación primaria',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],
            [
                'name'        => 'Secundario',
                'description' => 'Educación secundaria',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],
            [
                'name'        => 'Terciario',
                'description' => 'Educación terciaria',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now()
            ],

        ]);
    }
}
