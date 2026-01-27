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

        // Solo notificamos si se ha marcado como realizada
        if ($tarea->realizado) {

            // 1. Notificación en la Interfaz de Usuario para el Alumno
            Notification::make()
                ->title('Tarea finalizada')
                ->success()
                ->body('Se ha enviado el aviso a tu responsable.')
                ->send();

            // 2. Notificación a la Base de Datos para el Responsable
            // Buscamos al usuario que coincide con el id_responsable de la tarea
            $responsable = User::find($tarea->id_responsable);

            if ($responsable) {
                Notification::make()
                    ->title('Tarea completada por alumno')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->body("El alumno ha marcado la tarea: \"{$tarea->nombre}\" como realizada.")
                    ->sendToDatabase($responsable);
            }
        }
    }
}
