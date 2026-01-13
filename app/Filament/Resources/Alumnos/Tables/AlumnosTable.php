<?php

namespace App\Filament\Resources\Alumnos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables;

class AlumnosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                // ID del alumno (autoincremental, referencia al usuario)
                TextColumn::make('id_usuario')
                    ->numeric()
                    ->sortable(),

                // Nombre del usuario relacionado
                TextColumn::make('usuario.nombre')
                    ->label('Nombre')
                    ->sortable(),

                // Email del usuario relacionado
                TextColumn::make('usuario.email')
                    ->label('Email')
                    ->sortable(),

                // Fecha de creación del registro (opcional mostrar/ocultar)
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Fecha de actualización del registro (opcional mostrar/ocultar)
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Aquí puedes agregar filtros si quieres
            ])
            ->recordActions([
                // Acción de editar individual
                EditAction::make(),

                // Acción de eliminar individual
                DeleteAction::make()
                    ->before(function ($record) {
                        // Eliminar el usuario relacionado antes de eliminar el alumno
                        if ($record->usuario) {
                            $record->usuario->delete();
                        }
                    }),
            ])
            ->toolbarActions([
                // Acciones masivas (seleccionar varios registros)
                BulkActionGroup::make([
                    // Acción de borrar varios registros (opcional)
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
