<?php

namespace App\Filament\Resources\Tareas\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\BadgeColumn;

class TareasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_tarea')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('nombre')
                    ->label('Tarea')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('grupo.nombre_grupo')
                    ->label('Grupo')
                    ->sortable()
                    ->searchable(),

              TextColumn::make('responsable.usuario.nombre')
                    ->label('Responsable')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('fase.nombre')
                    ->label('Fase')
                    ->sortable()
                    ->toggleable(), // se puede ocultar

                TextColumn::make('fecha_inicio')
                    ->label('Inicio')
                    ->dateTime('d/m/Y H:i'),

                TextColumn::make('fecha_fin')
                    ->label('Fin')
                    ->dateTime('d/m/Y H:i'),

                BadgeColumn::make('realizado')
                    ->label('Estado')
                    ->colors([
                        'danger' => false,
                        'success' => true,
                    ])
                    ->formatStateUsing(fn ($state) => $state ? 'Realizado' : 'Pendiente'),

                IconColumn::make('visible')
                    ->label('Visible')
                    ->boolean(),
            ])
            ->filters([
                // Filtro por grupo
                Tables\Filters\SelectFilter::make('grupo_id')
                    ->relationship('grupo', 'nombre_grupo')
                    ->label('Grupo'),

                // Filtro por fase
                Tables\Filters\SelectFilter::make('id_fase')
                    ->relationship('fase', 'nombre')
                    ->label('Fase'),
            ])
            ->recordActions([
                EditAction::make(),
               DeleteAction::make(), // eliminar individual
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
