<?php

namespace App\Filament\Resources\NotificacionTareas\Pages;

use App\Filament\Resources\NotificacionTareas\NotificacionTareaResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditNotificacionTarea extends EditRecord
{
    protected static string $resource = NotificacionTareaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
