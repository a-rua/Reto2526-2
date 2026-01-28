<?php

namespace App\Filament\Resources\Alumnos\Pages;

use App\Filament\Resources\Alumnos\AlumnoResource;
use App\Models\Usuario;
use Filament\Resources\Pages\EditRecord;

class EditAlumno extends EditRecord
{
    protected static string $resource = AlumnoResource::class;

  protected function mutateFormDataBeforeFill(array $data): array
{
    if ($this->record->usuario) {
        $data['usuario'] = [
            'nombre' => $this->record->usuario->nombre,
            'email' => $this->record->usuario->email,
         'password' => $this->record->usuario->password,
        ];
    }
    return $data;
}

protected function mutateFormDataBeforeSave(array $data): array
{
    if (isset($data['usuario'])) {
        $usuario = $this->record->usuario;
        $usuario->nombre = $data['usuario']['nombre'];
        $usuario->email = $data['usuario']['email'];

        // Solo encriptamos si el usuario escribió una nueva contraseña
        if (!empty($data['usuario']['password'])) {
            $usuario->password = bcrypt($data['usuario']['password']);
        }

        $usuario->save();
        unset($data['usuario']);
    }
    return $data;
}
}
