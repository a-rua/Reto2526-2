<?php

namespace App\Filament\Resources\Materiales\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class MaterialesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_material')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('nombre_material')
                    ->label('Material')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->limit(50),

                TextColumn::make('proveedor.nombre_proveedor')
                    ->label('Proveedor')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('tareas')
                    ->label('Tareas')
                    ->badge()
                    ->getStateUsing(fn ($record) => $record->tareas->pluck('nombre')->toArray())
                    ->listWithLineBreaks(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('id_proveedores')
                    ->relationship('proveedor', 'nombre_proveedor')
                    ->label('Proveedor'),

                Tables\Filters\SelectFilter::make('tareas')
                    ->relationship('tareas', 'nombre')
                    ->label('Tarea'),
            ]);
    }
}
