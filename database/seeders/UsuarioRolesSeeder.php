<?php

namespace Database\Seeders;

use App\Models\Alumno;
use App\Models\Grupo;
use App\Models\Responsable;
use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioRolesSeeder extends Seeder
{
    public function run(): void
    {
        $grupo = Grupo::create([
            'nombre_grupo' => 'Grupo A',
            'descripcion' => 'Grupo de prueba para los alumnos',
        ]);

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
        // Crear el alumno y asignarle el grupo

        Alumno::create([
            'id_usuario' => $alumno->id_usuario,
            'grupo_id' => $grupo->id,
        ]);
    }
}
