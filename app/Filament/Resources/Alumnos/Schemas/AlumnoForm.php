<?php

namespace App\Filament\Resources\Alumnos\Schemas;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Unique; // Importa esta clase
use Illuminate\Database\Eloquent\Model; // Importa esta clase
use Filament\Forms\Components\TextInput;
class AlumnoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([


                // Nombre del usuario
                TextInput::make('usuario.nombre')
                    ->label('Nombre')
                    ->required()
                    // Especificar la tabla y usar modifyRuleUsing para el ID correcto
                    ->unique(table: 'usuarios', column: 'nombre', modifyRuleUsing: function (Unique $rule, ?Model $record) {
                        if ($record && $record->usuario) {
                            return $rule->ignore($record->usuario->id_usuario, 'id_usuario');
                        }
                        return $rule;
                    }),

                // Email del usuario
                TextInput::make('usuario.email')
                    ->label('Email')
                    ->email()
                    ->required()
                    // Especificar la tabla y usar modifyRuleUsing para el ID correcto
                    ->unique(table: 'usuarios', column: 'email', modifyRuleUsing: function (Unique $rule, ?Model $record) {
                        if ($record && $record->usuario) {
                            return $rule->ignore($record->usuario->id_usuario, 'id_usuario');
                        }
                        return $rule;
                    }),

Forms\Components\TextInput::make('usuario.password')
    ->password()
    ->required(fn (string $operation): bool => $operation === 'create')
    // Cambia la lógica de deshidratación para permitir que el valor pase si está relleno
    ->dehydrated(fn ($state) => filled($state)),

                // Grupo del alumno
                Select::make('grupo_id')
                    ->label('Grupo')
                    ->relationship('grupo', 'nombre_grupo')
                    ->searchable()
                    ->required(),
            ]);
    }
}
