<?php

namespace Database\Seeders;

use App\Models\Students;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Crear roles
        $rolesData = [
            [
                'name'         => 'Superadmin',
                'display_name' => 'superadmin'
            ],
            [
                'name'         => 'Colegio',
                'display_name' => 'colegio'
            ],
            [
                'name'         => 'Docente',
                'display_name' => 'docente'
            ],
            [
                'name'         => 'Alumno',
                'display_name' => 'alumno'
            ],
        ];

        foreach ($rolesData as $roleData) {
            Role::create($roleData);
        }

        // Crear usuarios
        $users = [
            [
                'name'     => 'Superadmin',
                'email'    => 'superadmin@gmail.com',
                'password' => '123456',
                'school_id' => '1',
                'roles'    => ['superadmin'], // Asignar el rol 'Superadmin'
            ],
            [
                'name'     => 'Colegio',
                'email'    => 'colegio_admin@gmail.com',
                'password' => '123456',
                'school_id' => 1,
                'roles'    => ['colegio'], // Asignar el rol 'Colegio'
            ],

          
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name'      => $userData['name'],
                'email'     => $userData['email'],
                'password'  => Hash::make($userData['password']),
                'school_id' => 1
            ]);

            // Asignar roles al usuario
            if (isset($userData['roles'])) {
                $user->assignRole($userData['roles']);
            }
        }
    }
}
