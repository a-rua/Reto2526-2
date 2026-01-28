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

    // Usamos id_usuario porque tu migración apunta a la tabla usuarios
    if ($tarea->realizado) {
        \App\Models\NotificacionTarea::updateOrCreate(
            [
                'id_tarea' => $tarea->id_tarea,
                'alumno_id' => $user->id_usuario,
            ],
            [
                'responsable_id' => $tarea->id_responsable,
                'comentario' => $tarea->comentario_alumno,
                'leido_at' => null,
            ]
        );
    }
}
}
