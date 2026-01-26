<?php

namespace App\Filament\Resources\Responsables\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

class ResponsableForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('u_nombre')
                ->label('Nombre Completo')
                ->required(),

            TextInput::make('u_email')
                ->label('Correo Electrónico')
                ->email()
                ->required(),

            TextInput::make('u_password')
                ->label('Contraseña')
                ->password()
                ->required(fn ($operation) => $operation === 'create'),

            Toggle::make('admin')
                ->label('¿Es Administrador?')
                ->default(false),
        ]);
    }
}
