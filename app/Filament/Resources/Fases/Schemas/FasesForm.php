<?php

namespace App\Filament\Resources\Fases\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use App\Models\Tarea;
use Illuminate\Validation\Rules\Unique;
use Illuminate\Database\Eloquent\Model;
class FasesForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
             ->components([
                TextInput::make('nombre')
                     ->label('Nombre de la Fase')
                    ->required()
                    ->maxLength(255)

                    ->unique(table: 'fases', column: 'nombre', modifyRuleUsing: function (Unique $rule, ?Model $record) {

                        if ($record) {
                            return $rule->ignore($record->id_fase, 'id_fase');
                        }
                        return $rule;
                    }),

                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->maxLength(500)
                    ->rows(3),

                Select::make('tareas')
                    ->label('Tareas asignadas')
                    ->multiple()
                    ->relationship('tareas', 'nombre')
                    ->preload()
                    ->searchable()
                    ->hint('Selecciona las tareas que pertenecen a esta fase')
                    // Esta función se encarga de guardar manualmente en la tabla 'tareas'
                    ->saveRelationshipsUsing(function ($record, $state) {
                        // 1. Limpiamos las tareas que antes tenían esta fase
                        Tarea::where('id_fase', $record->id_fase)
                            ->update(['id_fase' => null]);

                        // 2. Asignamos la nueva fase a las tareas seleccionadas
                        if (!empty($state)) {
                            Tarea::whereIn('id_tarea', $state)
                                ->update(['id_fase' => $record->id_fase]);
                        }
                    }),
            ]);
    }
}
