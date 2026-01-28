<?php

namespace App\Filament\Resources\Materiales\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class MaterialesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre_material')
                    ->label('Nombre del Material')
                    ->required()
                    ->maxLength(255),

                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->rows(3),

                Select::make('id_proveedores')
                    ->label('Proveedor')
                    ->required()
                    ->relationship('proveedor', 'nombre_proveedor')
                    ->searchable()
                    ->preload()
                    ->nullable(),

                // AÑADIMOS LA RELACIÓN CON TAREAS
                Select::make('tareas')
                    ->label('Asignar a Tareas')
                    ->required()
                    ->relationship('tareas', 'nombre') // Relación 'tareas', columna 'nombre'
                    ->multiple() // Permite elegir varias tareas
                    ->searchable()
                    ->preload()
                    ->hint('Puedes asignar este material a una o varias tareas existentes'),
            ]);
    }
}
