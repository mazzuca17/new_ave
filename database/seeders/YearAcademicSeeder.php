<?php

namespace Database\Seeders;

use App\Models\AcademicYears;
use Illuminate\Database\Seeder;

class YearAcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AcademicYears::create([
            'school_id'  => 1,
            'name'       => '2025',
            'start_date' => '2025-01-01',
            'end_date'   => '2205-12-31',
            'status'     => 1

        ]);
    }
}
