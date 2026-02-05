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
    $tarea = $this->getRecord(); // El modelo Tarea
    $user = auth()->user();

    // Obtenemos los datos que el usuario escribió en el formulario
    $data = $this->form->getState();
    $comentarioEscrito = $data['comentario_alumno'] ?? null;

    $responsable = $tarea->responsable;

    if ($tarea->realizado && $responsable) {
        \App\Models\NotificacionTarea::updateOrCreate(
            [
                'id_tarea' => $tarea->id_tarea,
                'alumno_id' => $user->id_usuario,
            ],
            [
                'responsable_id' => $responsable->id_usuario,
                'comentario' => $comentarioEscrito,
                'leido_at' => null,
            ]
        );
    }
}
}
