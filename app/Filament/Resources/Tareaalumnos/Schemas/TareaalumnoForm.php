<?php

namespace App\Filament\Resources\Tareaalumnos\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Textarea;

class TareaalumnoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Interruptor de estado
                Toggle::make('realizado')
                    ->label('¿Has terminado esta tarea?')
                    ->onColor('success'),

                // Campo de comentarios
                Textarea::make('comentario_alumno') // Asegúrate de que esta columna exista en tu DB
                    ->label('Comentarios sobre la entrega')
                    ->placeholder('Escribe aquí si tienes algo que reportar...')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }
}
