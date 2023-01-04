<?php

namespace Database\Seeders;

use App\Models\Schools;
use Carbon\Carbon;
use Faker\Provider\Lorem;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schools::create([
            'name'        => 'Colegio Demo',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Animi vel, velit enim ipsam saepe eius labore, ex dolores quod aut amet ut! Accusamus exercitationem praesentium laboriosam dicta at architecto molestiae!',
            'user_id'     => 2,
            'created_at'  => Carbon::now(),
            'updated_at'  => Carbon::now(),
        ]);
    }
}
