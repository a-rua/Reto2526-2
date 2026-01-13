<?php

namespace App\Filament\Resources\Alumnos\Pages;

use App\Filament\Resources\Alumnos\AlumnoResource;
use App\Models\Alumno;
use App\Models\Usuario;
use Filament\Resources\Pages\CreateRecord;
use Filament\Forms;

class CreateAlumno extends CreateRecord
{
    protected static string $resource = AlumnoResource::class;

    // Sobrescribimos el método create para manejar usuario + alumno
    protected function handleRecordCreation(array $data): Alumno
    {
        // 1Crear el usuario primero
        $usuario = Usuario::create([
            'nombre' => $data['usuario']['nombre'],
            'email' => $data['usuario']['email'],
            'password' => bcrypt($data['usuario']['password']),
            'activo' => true,
        ]);

        // 2 Crear el alumno relacionado
        return Alumno::create([
            'id_usuario' => $usuario->id_usuario,
        ]);
    }
}
