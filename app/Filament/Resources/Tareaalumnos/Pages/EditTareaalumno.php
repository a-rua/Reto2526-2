<?php

namespace App\Filament\Resources\Tareaalumnos\Pages;

use App\Filament\Resources\Tareaalumnos\TareaalumnoResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use App\Models\User;

class EditTareaalumno extends EditRecord
{
    protected static string $resource = TareaalumnoResource::class;

 protected function afterSave(): void
{
    $tarea = $this->record;

    if ($tarea->realizado) {
        \App\Models\NotificacionTarea::create([
         'id_tarea'       => $tarea->id_tarea, // <--- Usar 'id_tarea'
            'alumno_id'      => auth()->user()->id_usuario, // Usamos la clave primaria correcta
            'responsable_id' => $tarea->id_responsable,
            'comentario'     => $tarea->comentario_alumno, // El texto que escribe el alumno
        ]);

        // Notificación visual para el responsable
        $responsable = \App\Models\Usuario::find($tarea->id_responsable);
        if ($responsable) {
            \Filament\Notifications\Notification::make()
                ->title('Tarea completada')
                ->success()
                ->body("El alumno ha terminado: {$tarea->nombre}")
                ->sendToDatabase($responsable);
        }
    }
}
}
