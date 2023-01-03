<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = Role::create(['name' => 'Superadmin']);
        $admin      = Role::create(['name' => 'Colegio']);
        $alumno     = Role::create(['name' => 'Alumno']);
        $docente    = Role::create(['name' => 'Docente']);

        // Permisos de usuarios
        
    }
}
