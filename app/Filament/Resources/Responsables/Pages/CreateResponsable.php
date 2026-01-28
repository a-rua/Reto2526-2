<?php

namespace App\Filament\Resources\Responsables\Pages;

use App\Filament\Resources\Responsables\ResponsableResource;
use App\Models\Usuario;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateResponsable extends CreateRecord
{
    protected static string $resource = ResponsableResource::class;

 protected function handleRecordCreation(array $data): \App\Models\Responsable
{
    // 1. Accedemos al sub-array 'usuario' que viene del formulario
    $usuarioData = $data['usuario'];

    // 2. Creamos el Usuario con los datos correctos
    $usuario = \App\Models\Usuario::create([
        'nombre'   => $usuarioData['nombre'], // Antes buscabas $data['u_nombre']
        'email'    => $usuarioData['email'],
        'password' => bcrypt($usuarioData['password']),
        'activo'   => true,
    ]);

    // 3. Creamos el Responsable vinculado al nuevo usuario
    return \App\Models\Responsable::create([
        'id_usuario' => $usuario->id_usuario,
        'admin'      => $data['admin'] ?? false,
    ]);
}
}
