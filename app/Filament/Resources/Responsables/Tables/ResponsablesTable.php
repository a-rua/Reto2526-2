<?php

namespace App\Filament\Resources\Responsables\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ResponsablesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('usuario.nombre')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('usuario.email')
                    ->label('Email')
                    ->sortable()
                    ->searchable(),

                BadgeColumn::make('admin')
                    ->label('Rol')
                    ->formatStateUsing(fn ($state) => $state ? 'Admin' : 'Profesor')
                    ->colors([
                        'danger' => fn ($state) => ! $state,   // Profesor = rojo
                        'success' => fn ($state) => $state,    // Admin = verde
                    ]),
            ])
            ->filters([
                SelectFilter::make('admin')
                    ->label('Rol')
                    ->options([
                        '1' => 'Admin',
                        '0' => 'Profesor',
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
