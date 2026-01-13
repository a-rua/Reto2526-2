<?php

namespace App\Filament\Resources\Alumnos\Pages;

use App\Filament\Resources\Alumnos\AlumnoResource;
use App\Models\Usuario;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditAlumno extends EditRecord
{
    protected static string $resource = AlumnoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * Antes de guardar el alumno, actualizamos los datos del usuario relacionado
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['usuario'])) {
            $usuarioData = $data['usuario'];
            $usuario = $this->record->usuario;

            if ($usuarioData['nombre'] ?? false) {
                $usuario->nombre = $usuarioData['nombre'];
            }

            if ($usuarioData['email'] ?? false) {
                $usuario->email = $usuarioData['email'];
            }

            if (!empty($usuarioData['password'])) {
                $usuario->password = bcrypt($usuarioData['password']);
            }

            $usuario->save();
        }

        // No guardamos ningún dato directamente en Alumno, retornamos vacío
        return [];
    }
}
