<?php

namespace App\Filament\Resources\Alumnos\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;

class AlumnoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Nombre del usuario
                Forms\Components\TextInput::make('usuario.nombre')
                    ->label('Nombre')
                    ->required(), // obligatorio

                // Email del usuario
                Forms\Components\TextInput::make('usuario.email')
                    ->label('Email')
                    ->email()
                    ->required(), // obligatorio

                // Password del usuario
                Forms\Components\TextInput::make('usuario.password')
                    ->label('Contraseña')
                    ->password()
                    ->required() // obligatorio
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state)), // encriptar al guardar
            ]);
    }
}
