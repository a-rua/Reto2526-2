<?php

namespace App\Filament\Resources\Alumnos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

use App\Models\Alumno;
class AlumnosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // Nombre del usuario relacionado
                TextColumn::make('usuario.nombre')
                    ->label('Nombre')
                    ->sortable(),

                // Email del usuario relacionado
                TextColumn::make('usuario.email')
                    ->label('Email')
                    ->sortable(),
                TextColumn::make('grupo.nombre_grupo')
                    ->label('Grupo')
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
    ->after(function (Alumno $record) {
        // Una vez borrado el alumno, buscamos y borramos su usuario
        if ($record->id_usuario) {
            \App\Models\Usuario::where('id_usuario', $record->id_usuario)->delete();
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
