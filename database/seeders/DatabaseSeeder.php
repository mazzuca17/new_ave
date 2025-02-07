<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(SchoolSeeder::class);
        $this->call(CursosSeeder::class);
        $this->call(MateriasSeeder::class);
        $this->call(TypeEventosSeeder::class);
    }
}
