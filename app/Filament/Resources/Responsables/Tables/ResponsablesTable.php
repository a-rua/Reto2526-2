<?php

namespace App\Filament\Resources\Responsables\Tables;

use App\Models\Responsable;
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
                        'danger' => false,  // Rojo para Profesor (0)
                        'success' => true,  // Verde para Admin (1)
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
            ->actions([ // Cambiado recordActions por actions para Filament estándar
                EditAction::make(),
                DeleteAction::make()
                    ->after(function (Responsable $record) {
                        // Borra el usuario asociado después de borrar al responsable
                        $record->usuario?->delete();
                    }),
            ])
            ->bulkActions([ // Cambiado toolbarActions por bulkActions
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->after(function (\Illuminate\Database\Eloquent\Collection $records) {
                            // Borra los usuarios de todos los responsables seleccionados
                            $records->each(fn ($record) => $record->usuario?->delete());
                        }),
                ]),
            ]);
    }
}
