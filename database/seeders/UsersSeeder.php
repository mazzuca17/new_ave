<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //User::truncate();
        $users = [
            [
                'name'     => 'Superadmin',
                'email'    => 'superadmin@gmail.com',
                'password' => '123456',
                'is_admin' => '1',
            ],
            [
                'name'     => 'Colegio',
                'email'    => 'colegio_admin@gmail.com',
                'password' => '123456',
                'is_admin' => null,
            ],
            [
                'name'     => 'Alumno',
                'email'    => 'alumno@gmail.com',
                'password' => '123456',
                'is_admin' => null,
            ],
            [
                'name'     => 'Docente',
                'email'    => 'docente@gmail.com',
                'password' => '123456',
                'is_admin' => null,
            ]
        ];

        foreach ($users as $user) {
            User::create([
                'name'     => $user['name'],
                'email'    => $user['email'],
                'password' => Hash::make($user['password'])
            ]);
        }
    }
}
