<?php

namespace App\Filament\Resources\Responsables\Pages;

use App\Filament\Resources\Responsables\ResponsableResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Models\Responsable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
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


  protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return DB::transaction(function () use ($record, $data) {
            if (isset($data['usuario'])) {
                $usuario = $record->usuario;
                $usuario->nombre = $data['usuario']['nombre'];
                $usuario->email = $data['usuario']['email'];

                // Solo actualiza si el admin escribió una nueva clave
                if (!empty($data['usuario']['password'])) {
                    $usuario->password = bcrypt($data['usuario']['password']);
                }

                $usuario->save();
            }

            // Limpiamos el array de datos para que no falle al actualizar el Alumno
            unset($data['usuario']);
            $record->update($data);

            return $record;
        });
    }

}
