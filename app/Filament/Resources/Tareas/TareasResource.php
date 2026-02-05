<?php

namespace App\Filament\Resources\Tareas;

use App\Filament\Resources\Tareas\Pages\CreateTareas;
use App\Filament\Resources\Tareas\Pages\EditTareas;
use App\Filament\Resources\Tareas\Pages\ListTareas;
use App\Filament\Resources\Tareas\Schemas\TareasForm;
use App\Filament\Resources\Tareas\Tables\TareasTable;
use App\Filament\Resources\Tareas\RelationManagers\MaterialesRelationManager;
use App\Models\Tarea;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class TareasResource extends Resource
{
    protected static ?string $model = Tarea::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Tarea';
public static function getEloquentQuery(): Builder
{
    $user = auth()->user();
    $query = parent::getEloquentQuery();

    // El admin ve todo
    if ($user->isAdmin()) {
        return $query;
    }

    // El profesor solo ve sus tareas
    // Usamos $user->responsable->id para obtener el ID de la tabla responsables
    return $query->where('id_responsable', $user->responsable?->id);
}
     public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return $user->isAdmin() || $user->isProfesor();
    }

    public static function canViewAny(): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        return $user->isAdmin() || $user->isProfesor();
    }

    public static function form(Schema $schema): Schema
    {
        return TareasForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TareasTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
                MaterialesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTareas::route('/'),
            'create' => CreateTareas::route('/create'),
            'edit' => EditTareas::route('/{record}/edit'),
        ];
    }
}
