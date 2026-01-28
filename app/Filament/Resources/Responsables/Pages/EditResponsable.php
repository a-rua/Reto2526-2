<?php

namespace App\Filament\Resources\Responsables\Pages;

use App\Filament\Resources\Responsables\ResponsableResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Models\Responsable;
class EditResponsable extends EditRecord
{
    protected static string $resource = ResponsableResource::class;

    protected function getHeaderActions(): array
    {
        return [
          DeleteAction::make()
                    ->after(function (Responsable $record) {
                        // Borra el usuario asociado después de borrar al responsable
                        $record->usuario?->delete();
                    }),
        ];
    }

    /**
     * Paso 1: Cargar los datos del Usuario relacionado en el formulario.
     */
  protected function mutateFormDataBeforeFill(array $data): array
{
    if ($this->record->usuario) {
        $data['usuario'] = [
            'nombre' => $this->record->usuario->nombre,
            'email'  => $this->record->usuario->email,
            'password' => null, // IMPORTANTE: vacío
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

        $usuario->nombre = $usuarioData['nombre'];
        $usuario->email  = $usuarioData['email'];

        if (!empty($usuarioData['password'])) {
            $usuario->password = bcrypt($usuarioData['password']);
        }

        $usuario->save();

        unset($data['usuario']);
    }

    return $data;
}

}
