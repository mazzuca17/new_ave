<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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
                'is_admin' => '1',
                'roles'    => ['superadmin'], // Asignar el rol 'Superadmin'
            ],
            [
                'name'     => 'Colegio',
                'email'    => 'colegio_admin@gmail.com',
                'password' => '123456',
                'is_admin' => null,
                'roles'    => ['colegio'], // Asignar el rol 'Colegio'
            ],
            [
                'name'     => 'Alumno',
                'email'    => 'alumno@gmail.com',
                'password' => '123456',
                'is_admin' => null,
                'roles'    => ['alumno'], // Asignar el rol 'Alumno'
            ],
            [
                'name'     => 'Docente',
                'email'    => 'docente@gmail.com',
                'password' => '123456',
                'is_admin' => null,
                'roles'    => ['docente'], // Asignar el rol 'Docente'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name'     => $userData['name'],
                'email'    => $userData['email'],
                'password' => Hash::make($userData['password'])
            ]);

            // Asignar roles al usuario
            if (isset($userData['roles'])) {
                $user->assignRole($userData['roles']);
            }
        }
    }
}
