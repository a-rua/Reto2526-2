<?php

namespace App\Filament\Resources\Grupos\Schemas;

use App\Models\Alumno;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class GrupoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('nombre_grupo')
                ->label('Nombre del Grupo')
                ->required()
                ->maxLength(255),

            Textarea::make('descripcion')
                ->label('Descripción')
                ->required(),

            Select::make('alumnos')
                ->label('Asignar Alumnos')
                ->multiple()
                ->searchable()
                ->getSearchResultsUsing(function (string $search, $record) {
                    return Alumno::with('usuario')
                        ->where(function ($q) use ($record) {
                            $q->whereNull('grupo_id');
                            if ($record) {
                                $q->orWhere('grupo_id', $record->id);
                            }
                        })
                        ->whereHas('usuario', function ($q) use ($search) {
                            $q->where('nombre', 'like', "%{$search}%");
                        })
                        ->limit(10)
                        ->get()
                        ->pluck('usuario.nombre', 'id');
                })
                ->getOptionLabelsUsing(function (array $values) {
                    return Alumno::with('usuario')
                        ->whereIn('id', $values)
                        ->get()
                        ->pluck('usuario.nombre', 'id');
                }),

            Placeholder::make('alumnos_actuales')
                ->label('Alumnos en este grupo')
                ->content(function ($get, $record) {
                    // $record es el  Grupo actual
                    if (! $record) {
                        return 'Sin alumnos asignados';
                    }

                    // Asegurarse de cargar la relación
                    $record->loadMissing('alumnos.usuario');

                    // Obtener los nombres de los alumnos
                    $nombres = $record->alumnos->map(fn ($alumno) => $alumno->usuario->nombre)->toArray();

                    return count($nombres) ? implode(', ', $nombres) : 'Sin alumnos asignados';
                }),

        ]);
    }
}
