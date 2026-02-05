<?php

namespace App\Filament\Resources\Fases\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
// Usamos los namespaces de Tables\Actions para la tabla
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class FasesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_fase')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('nombre')
                    ->label('Nombre de la Fase')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50),


                TextColumn::make('tareas.nombre')
                    ->label('Tareas')
                    ->badge()
                    ->separator(',')
                    ->searchable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                // Puedes añadir un filtro por tarea si quieres
                Tables\Filters\SelectFilter::make('tareas')
                    ->relationship('tareas', 'nombre')
                    ->label('Filtrar por Tarea'),
            ])
            // En Filament v4, usamos actions() y bulkActions()
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
