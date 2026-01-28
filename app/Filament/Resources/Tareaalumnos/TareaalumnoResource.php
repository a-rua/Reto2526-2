<?php

namespace App\Filament\Resources\Tareaalumnos;

use App\Filament\Resources\Tareaalumnos\Schemas\TareaalumnoForm;
use App\Filament\Resources\Tareaalumnos\Pages;
use App\Models\Tarea;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema; // <--- IMPRESCINDIBLE PARA EL MÉTODO FORM
use Filament\Tables\Table;
use Filament\Actions\EditAction; // <--- CORREGIDO PARA TABLAS
use Illuminate\Database\Eloquent\Builder;

class TareaalumnoResource extends Resource
{
    protected static ?string $model = Tarea::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Mis Tareas';
public static function canAccess(): bool
{
    $user = auth()->user();

    // Solo permite el acceso si el usuario está logueado y tiene perfil de alumno
    return $user && $user->isAlumno();
}
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery();

        if ($user?->alumno) {
            return $query->where('grupo_id', $user->alumno->grupo_id);
        }

        return $query;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit($record): bool
    {
        return true;
    }

    /**
     * Ahora que importamos Filament\Forms\Form, esto cargará los componentes
     * definidos en tu Schema.
     */
   public static function form(Schema $schema): Schema
    {
        return TareaalumnoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('nombre')->label('Tarea'),
                \Filament\Tables\Columns\TextColumn::make('fecha_fin')->label('Fecha Fin'),
                \Filament\Tables\Columns\IconColumn::make('realizado')
                    ->boolean()
                    ->label('¿Hecha?'),
            ])
            ->recordAction(EditAction::class)
            ->actions([
                EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTareaalumnos::route('/'),
            'edit' => Pages\EditTareaalumno::route('/{record}/edit'),
        ];
    }
}
