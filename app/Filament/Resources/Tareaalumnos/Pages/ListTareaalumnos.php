<?php

namespace App\Filament\Resources\Tareaalumnos\Pages;

use App\Filament\Resources\Tareaalumnos\TareaalumnoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTareaalumnos extends ListRecords
{
    protected static string $resource = TareaalumnoResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
