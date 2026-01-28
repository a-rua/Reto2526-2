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
            ->required()
            ->unique(
                table: 'usuarios',
                column: 'nombre',
                ignorable: fn ($record) => $record?->usuario
            ),

        TextInput::make('usuario.email') // Antes era u_email
            ->label('Correo Electrónico')
            ->email()
            ->required()
            ->unique(
                table: 'usuarios',
                column: 'email',
                ignorable: fn ($record) => $record?->usuario
            ),

       TextInput::make('usuario.password')
    ->password()
    ->label('Contraseña')
    ->dehydrated(fn ($state) => filled($state)) // solo guarda si hay algo
    ->required(false)
    ->placeholder('Dejar vacío para no cambiarla'),

        Toggle::make('admin')
            ->label('¿Es Administrador?')
            ->default(false),
    ]);
}
}
