<?php

namespace App\Filament\Resources\Grupos\Pages;

use App\Filament\Resources\Grupos\GrupoResource;
use App\Models\Alumno;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditGrupo extends EditRecord
{
    protected static string $resource = GrupoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    // Sobrescribimos la actualización para manejar la relación alumnos
    protected function handleRecordUpdate(\Illuminate\Database\Eloquent\Model $record, array $data): \Illuminate\Database\Eloquent\Model
    {
        // Actualizamos el grupo (propiedades básicas)
        $grupo = parent::handleRecordUpdate($record, $data);

        // Actualizamos los alumnos asignados
        if (isset($data['alumnos']) && is_array($data['alumnos'])) {
            foreach ($data['alumnos'] as $idAlumno) {
                $alumno = Alumno::find($idAlumno);
                if ($alumno) {
                    $alumno->grupo_id = $grupo->id;
                    $alumno->save();
                }
            }
        }

        return $grupo; // Muy importante: siempre devolver el modelo
    }
}
