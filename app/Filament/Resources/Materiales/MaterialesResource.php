<?php

namespace App\Filament\Resources\Materiales;

use App\Filament\Resources\Materiales\Pages\CreateMateriales;
use App\Filament\Resources\Materiales\Pages\EditMateriales;
use App\Filament\Resources\Materiales\Pages\ListMateriales;
use App\Filament\Resources\Materiales\Schemas\MaterialesForm;
use App\Filament\Resources\Materiales\Tables\MaterialesTable;
use App\Filament\Resources\Materiales\RelationManagers\TareasRelationManager;
use App\Models\Material;
use App\Models\Tarea;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
class MaterialesResource extends Resource
{
    protected static ?string $model = Material::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Material';
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
        return MaterialesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MaterialesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListMateriales::route('/'),
            'create' => CreateMateriales::route('/create'),
            'edit' => EditMateriales::route('/{record}/edit'),
        ];
    }
}
