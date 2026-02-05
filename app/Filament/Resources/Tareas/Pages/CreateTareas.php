<?php

namespace App\Filament\Resources\Tareas\Pages;

use App\Filament\Resources\Tareas\TareasResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTareas extends CreateRecord
{
    protected static string $resource = TareasResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    // Asignamos el ID del usuario actual como responsable de la tarea
    $data['responsable_id'] = auth()->id();

    return $data;
}
}
