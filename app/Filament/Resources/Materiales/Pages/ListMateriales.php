<?php

namespace App\Filament\Resources\Materiales\Pages;

use App\Filament\Resources\Materiales\MaterialesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMateriales extends ListRecords
{
    protected static string $resource = MaterialesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
