<?php

namespace App\Filament\Resources\Grupos\Pages;

use App\Filament\Resources\Grupos\GrupoResource;
use App\Models\Alumno;
use Filament\Resources\Pages\CreateRecord;

class CreateGrupo extends CreateRecord
{
    protected static string $resource = GrupoResource::class;

    /**
     * Sobrescribimos la creación para asignar alumnos seleccionados al grupo
     */
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Crear el grupo usando el método base
        $grupo = parent::handleRecordCreation($data);

        // Si recibes un array de alumnos seleccionados en el formulario
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
