<?php

namespace Database\Seeders;

use App\Models\Students;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentsSeeder extends Seeder
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
                'name'      => 'Juan',
                'last_name' => 'Doe',
                'email'     => 'alumno@gmail.com',
                'password'  => '123456',
                'roles'     => ['alumno'],
            ],
            [
                'name'      => 'Sebastian',
                'last_name' => 'Doe',
                'email'     => 'alumno2@gmail.com',
                'password'  => '123456',
                'roles'     => ['alumno'],
            ],
            [
                'name'      => 'Marcelo',
                'last_name' => 'Doe',
                'email'     => 'alumno3@gmail.com',
                'password'  => '123456',
                'roles'     => ['alumno'],
            ],
        ];

        foreach ($students as $studentData) {
            // Crear usuario
            $user = User::create([
                'name'      => $studentData['name'],
                'last_name' => $studentData['last_name'],
                'email'     => $studentData['email'],
                'password'  => Hash::make($studentData['password']),
            ]);

            // Asignar roles al usuario
            if (isset($studentData['roles'])) {
                $user->assignRole($studentData['roles']);
            }

            // Crear estudiante con los nuevos campos
            Students::create([
                'user_id'           => $user->id,
                'curso_id'          => 1,
                'school_id'         => 1,
                'dni'               => mt_rand(10000000, 99999999), // Genera un DNI aleatorio de 8 dígitos
                'fecha_nacimiento'  => Carbon::createFromFormat('Y-m-d', '2000-' . mt_rand(1, 12) . '-' . mt_rand(1, 28)),
                'genero'            => ['masculino', 'femenino', 'otro'][array_rand(['masculino', 'femenino', 'otro'])],
                'direccion'         => 'Calle ' . mt_rand(1, 100) . ' - Ciudad X',
                'telefono'          => '+54 9 11 ' . mt_rand(1000, 9999) . '-' . mt_rand(1000, 9999),
                'nacionalidad'      => 'Argentina',
                'image_profile'     => null,
                'anio_ingreso'      => 2022,
                'promedio'          => mt_rand(60, 100) / 10,
                'condition'         => 'regular',
                'estado_matricula'  => 'inscrito',
                'beca'              => false,
                'nombre_tutor'      => 'Tutor ' . $studentData['last_name'],
                'telefono_tutor'    => '+54 9 11 ' . mt_rand(1000, 9999) . '-' . mt_rand(1000, 9999),
                'alergias'          => null,
                'seguro_medico'     => 'OSDE',
                'contacto_emergencia' => '+54 9 11 ' . mt_rand(1000, 9999) . '-' . mt_rand(1000, 9999),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
            ]);
        }
    }
}
