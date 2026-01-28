<?php

namespace App\Filament\Resources\Responsables\Pages;

use App\Filament\Resources\Responsables\ResponsableResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditResponsable extends EditRecord
{
    protected static string $resource = ResponsableResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    /**
     * Paso 1: Cargar los datos del Usuario relacionado en el formulario.
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Accedemos a la relación 'usuario' definida en el modelo Responsable
        if ($this->record->usuario) {
            $data['usuario'] = [
                'nombre' => $this->record->usuario->nombre,
                'email' => $this->record->usuario->email,
                'password' => $this->record->usuario->password,// Dejamos la contraseña vacía por seguridad al cargar
            ];
        }

        return $data;
    }

    /**
     * Paso 2: Guardar los cambios en el Usuario antes de actualizar el Responsable.
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['usuario'])) {
            $usuarioData = $data['usuario'];
            $usuario = $this->record->usuario;

            // Actualizamos nombre y email
            $usuario->nombre = $usuarioData['nombre'];
            $usuario->email = $usuarioData['email'];

            // Solo actualizamos y encriptamos la contraseña si el usuario escribió algo
            if (!empty($usuarioData['password'])) {
                $usuario->password = bcrypt($usuarioData['password']);
            }

            $usuario->save();

            // Quitamos los datos de 'usuario' del array $data para evitar errores
            // al intentar guardar campos inexistentes en la tabla 'responsables'
            unset($data['usuario']);
        }

        return $data;
    }
}
