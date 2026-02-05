<?php

namespace App\Filament\Resources\Tareaalumnos\Pages;

use App\Filament\Resources\Tareaalumnos\TareaalumnoResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Models\NotificacionTarea;
use App\Models\Usuario;

class EditTareaalumno extends EditRecord
{
    protected static string $resource = TareaalumnoResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }

protected function afterSave(): void
{
 $tarea = $this->record;
$user = auth()->user();

// 1. Obtenemos el objeto Responsable a través de la relación
// Esto usará el 'id_responsable' que ya tiene la tarea.
$responsable = $tarea->responsable;

if ($tarea->realizado && $responsable) {
    \App\Models\NotificacionTarea::updateOrCreate(
        [
            'id_tarea' => $tarea->id_tarea,
            'alumno_id' => $user->id_usuario,
        ],
        [
            /**
             * AQUÍ ESTÁ EL TRUCO:
             * Tu tabla 'notificacion_tareas' exige un ID de la tabla 'usuarios'.
             * Por eso sacamos el 'id_usuario' que está dentro del modelo Responsable.
             */
            'responsable_id' => $responsable->id_usuario,

            'comentario' => $tarea->comentario_alumno,
            'leido_at' => null,
        ]
    );
}
}
}
