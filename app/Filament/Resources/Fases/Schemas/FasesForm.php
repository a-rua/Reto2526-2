<?php

namespace App\Filament\Resources\Fases\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
class FasesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
             ->components([
                TextInput::make('nombre')
                    ->label('Nombre de la Fase')
                    ->required()
                    ->maxLength(255),

                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->maxLength(500)
                    ->rows(3),
            ]);
    }
}
