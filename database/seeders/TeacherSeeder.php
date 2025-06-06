<?php

namespace Database\Seeders;

use App\Models\Profesors;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Lista de estudiantes
        $students = [
            [
                'name'      => 'Docente',
                'last_name' => 'Doe',
                'email'     => 'docente@gmail.com',
                'password'  => '123456',
                'school_id' => 1,
                'roles'     => ['docente'], // Asignar el rol 'Docente'
            ],
            [
                'name'      => 'Docente2',
                'last_name' => 'Doe',
                'email'     => 'docente2@gmail.com',
                'password'  => '123456',
                'school_id' => 1,
                'roles'     => ['docente'], // Asignar el rol 'Docente'
            ],

            [
                'name'      => 'Docente3',
                'last_name' => 'Doe',
                'email'     => 'docente3@gmail.com',
                'password'  => '123456',
                'school_id' => 1,
                'roles'     => ['docente'], // Asignar el rol 'Docente'
            ],
        ];

        foreach ($students as $studentData) {
            // Crear usuario
            $user = User::create([
                'name'      => $studentData['name'],
                'last_name' => $studentData['last_name'],
                'email'     => $studentData['email'],
                'password'  => Hash::make($studentData['password']),
                'school_id' => 1
            ]);

            // Asignar roles al usuario
            if (isset($studentData['roles'])) {
                $user->assignRole($studentData['roles']);
            }

            // Crear estudiante con los nuevos campos
            Profesors::create([
                'user_id'           => $user->id,
                'school_id'         => 1,
                'dni'               => mt_rand(10000000, 99999999), // Genera un DNI aleatorio de 8 dígitos
                'fecha_nacimiento'  => Carbon::createFromFormat('Y-m-d', '2000-' . mt_rand(1, 12) . '-' . mt_rand(1, 28)),
                'genero'            => ['masculino', 'femenino', 'otro'][array_rand(['masculino', 'femenino', 'otro'])],
                'direccion'         => 'Calle ' . mt_rand(1, 100) . ' - Ciudad X',
                'telefono'          => '+54 9 11 ' . mt_rand(1000, 9999) . '-' . mt_rand(1000, 9999),
                'nacionalidad'      => 'Argentina',
                'image_profile'     => null,
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
        }
    }
}
