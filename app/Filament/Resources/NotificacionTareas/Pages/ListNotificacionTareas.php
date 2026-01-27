<?php

namespace App\Filament\Resources\NotificacionTareas\Pages;

use App\Filament\Resources\NotificacionTareas\NotificacionTareaResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListNotificacionTareas extends ListRecords
{
    protected static string $resource = NotificacionTareaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
