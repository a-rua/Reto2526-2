<?php

namespace App\Filament\Resources\Tareas\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;

class TareasForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nombre')
                    ->label('Nombre de la tarea')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                DateTimePicker::make('fecha_inicio')
                    ->label('Fecha de inicio')
                    ->nullable(),

                TimePicker::make('estimado')
                    ->label('Tiempo estimado')
                    ->nullable(),

                DateTimePicker::make('fecha_fin')
                    ->label('Fecha de fin')
                    ->nullable(),

                Toggle::make('visible')
                    ->label('Visible')
                    ->default(true),

                Toggle::make('realizado')
                    ->label('Realizado')
                    ->default(false),

                Select::make('grupo_id')
                    ->label('Grupo')
                    ->relationship('grupo', 'nombre_grupo')
                    ->searchable()
                    ->required(),



Select::make('id_responsable')
    ->label('Responsable')
    ->relationship(
        'responsable',
        'id',
        fn (Builder $query) => $query
            ->where('admin', false)
            ->with('usuario')
    )
    ->getOptionLabelFromRecordUsing(fn ($record) =>
        $record->usuario?->nombre ?? 'Sin usuario'
    )
    ->searchable()
    ->preload()
    ->required(),





                Select::make('id_fase')
                    ->label('Fase (opcional)')
                    ->relationship('fase', 'nombre')
                    ->nullable()
                    ->searchable()
                    ->preload(),
            ]);
    }
}
