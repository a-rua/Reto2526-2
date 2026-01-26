<?php

namespace App\Filament\Resources\Materiales\Pages;

use App\Filament\Resources\Materiales\MaterialesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditMateriales extends EditRecord
{
    protected static string $resource = MaterialesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
