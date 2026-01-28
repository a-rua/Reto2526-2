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
        TextInput::make('usuario.nombre') // Antes era u_nombre
            ->label('Nombre Completo')
            ->required(),

        TextInput::make('usuario.email') // Antes era u_email
            ->label('Correo Electrónico')
            ->email()
            ->required(),

        TextInput::make('usuario.password') // Antes era u_password
            ->label('Contraseña')
            // No uses ->password() si quieres verla como texto plano
            ->required(fn ($operation) => $operation === 'create'),

        Toggle::make('admin')
            ->label('¿Es Administrador?')
            ->default(false),
    ]);
}
}
