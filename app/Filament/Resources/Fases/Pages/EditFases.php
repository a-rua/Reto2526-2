<?php

namespace App\Filament\Resources\Fases\Pages;

use App\Filament\Resources\Fases\FasesResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditFases extends EditRecord
{
    protected static string $resource = FasesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
