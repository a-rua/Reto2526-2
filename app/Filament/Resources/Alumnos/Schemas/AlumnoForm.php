<?php

namespace App\Filament\Resources\Alumnos\Schemas;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;

class AlumnoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([

                // Nombre del usuario
                Forms\Components\TextInput::make('usuario.nombre')
                    ->label('Nombre')
                    ->required(),

                // Email del usuario
                Forms\Components\TextInput::make('usuario.email')
                    ->label('Email')
                    ->email()
                    ->required(),

                // Contraseña del usuario
                Forms\Components\TextInput::make('usuario.password')
                    ->label('Contraseña')
                    ->password()
                    ->required(fn ($record) => $record === null) // obligatorio solo al crear
                    ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null), // encriptar solo si cambia

                // Grupo del alumno
                Select::make('grupo_id')
                    ->label('Grupo')
                    ->relationship('grupo', 'nombre_grupo')
                    ->searchable()
                    ->required(),
            ]);
    }
}
