<?php

namespace App\Filament\Resources\Grupos;

use App\Filament\Resources\Grupos\Pages\CreateGrupo;
use App\Filament\Resources\Grupos\Pages\EditGrupo;
use App\Filament\Resources\Grupos\Pages\ListGrupos;
use App\Filament\Resources\Grupos\Schemas\GrupoForm;
use App\Filament\Resources\Grupos\Tables\GruposTable;
use App\Models\Grupo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class GrupoResource extends Resource
{
    protected static ?string $model = Grupo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'nombre_grupo';

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();

        return $user && ($user->isAdmin() || $user->isProfesor());
    }

    public static function canViewAny(): bool
    {
        $user = Auth::user();

        return $user && ($user->isAdmin() || $user->isProfesor());
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('alumnos.usuario');
    }

    public static function form(Schema $schema): Schema
    {
        return GrupoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GruposTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGrupos::route('/'),
            'create' => CreateGrupo::route('/create'),
            'edit' => EditGrupo::route('/{record}/edit'),
        ];
    }
}
