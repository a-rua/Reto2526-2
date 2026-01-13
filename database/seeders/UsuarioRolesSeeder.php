<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Responsable;
use App\Models\Alumno;

class UsuarioRolesSeeder extends Seeder
{
    public function run(): void
    {
        //  ADMIN
        $admin = Usuario::create([
            'nombre' => 'Administrador',
            'email' => 'admin@demo.com',
            'password' => Hash::make('password'),
            'activo' => true,
        ]);

        Responsable::create([
            'id_usuario' => $admin->id_usuario,
            'admin' => true,
        ]);

        //  RESPONSABLE
        $responsable = Usuario::create([
            'nombre' => 'Responsable',
            'email' => 'responsable@demo.com',
            'password' => Hash::make('password'),
            'activo' => true,
        ]);

        Responsable::create([
            'id_usuario' => $responsable->id_usuario,
            'admin' => false,
        ]);

        //  ALUMNO
        $alumno = Usuario::create([
            'nombre' => 'Alumno',
            'email' => 'alumno@demo.com',
            'password' => Hash::make('password'),
            'activo' => true,
        ]);

        Alumno::create([
            'id_usuario' => $alumno->id_usuario,
        ]);
    }
}
