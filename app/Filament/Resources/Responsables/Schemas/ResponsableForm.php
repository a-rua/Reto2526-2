<?php

namespace App\Filament\Resources\Responsables\Schemas;

use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ResponsableForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            Group::make()
                ->relationship('usuario') //  relación Responsable → Usuario
                ->schema([
                    TextInput::make('nombre')
                        ->label('Nombre')
                        ->required(),

                    TextInput::make('email')
                        ->label('Email')
                        ->email()
                        ->required(),

                    TextInput::make('password')
                        ->label('Contraseña')
                        ->password()
                        ->required(fn (string $context) => $context === 'create')
                        ->dehydrateStateUsing(
                            fn ($state) => filled($state) ? bcrypt($state) : null
                        )
                        ->dehydrated(fn ($state) => filled($state)),
                ]),
        ]);
    }
}
