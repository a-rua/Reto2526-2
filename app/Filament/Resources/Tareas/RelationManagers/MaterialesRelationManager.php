<?php

namespace App\Filament\Resources\Tareas\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Actions\AttachAction;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Actions\DetachBulkAction;
use Filament\Actions\BulkActionGroup;

class MaterialesRelationManager extends RelationManager
{
    protected static string $relationship = 'materiales';

    protected static ?string $recordTitleAttribute = 'nombre_material';


    public function configureSchema(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cantidad')
                    ->label('Cantidad')
                    ->numeric()
                    ->required()
                    ->default(1),
            ]);
    }


    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('cantidad')
                    ->label('Cantidad')
                    ->numeric()
                    ->required()
                    ->default(1),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nombre_material')
            ->columns([
                Tables\Columns\TextColumn::make('nombre_material')
                    ->label('Material')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('pivot.cantidad')
                    ->label('Cantidad')
                    ->sortable(),
            ])
            ->headerActions([
                AttachAction::make()
                    ->form(fn (AttachAction $action): array => [
                        $action->getRecordSelect(),
                        TextInput::make('cantidad')
                            ->label('Cantidad a asignar')
                            ->numeric()
                            ->default(1)
                            ->required(),
                    ])
                    ->preloadRecordSelect(),
            ])
            ->actions([
                EditAction::make(),
                DetachAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DetachBulkAction::make(),
                ]),
            ]);
    }
}
