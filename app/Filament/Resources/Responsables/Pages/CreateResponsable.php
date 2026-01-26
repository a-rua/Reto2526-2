<?php

namespace App\Filament\Resources\Responsables\Pages;

use App\Filament\Resources\Responsables\ResponsableResource;
use App\Models\Usuario;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateResponsable extends CreateRecord
{
    protected static string $resource = ResponsableResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 1. Creamos el Usuario en la tabla 'usuarios'
        $usuario = Usuario::create([
            'nombre'   => $data['u_nombre'],
            'email'    => $data['u_email'],
            'password' => Hash::make($data['u_password']),
            'activo'   => true,
        ]);

        // 2. Insertamos el ID generado en el campo que MySQL está reclamando
        $data['id_usuario'] = $usuario->id_usuario;

        // 3. Limpiamos los datos "temporales" para que no ensucien el INSERT de responsables
        unset($data['u_nombre'], $data['u_email'], $data['u_password']);

        // Ahora $data solo tiene: 'id_usuario' y 'admin'. MySQL ya no dará error.
        return $data;
    }
}
