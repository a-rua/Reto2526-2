<?php

namespace App\Filament\Resources\Responsables;

use App\Filament\Resources\Responsables\Pages\CreateResponsable;
use App\Filament\Resources\Responsables\Pages\EditResponsable;
use App\Filament\Resources\Responsables\Pages\ListResponsables;
use App\Filament\Resources\Responsables\Schemas\ResponsableForm;
use App\Filament\Resources\Responsables\Tables\ResponsablesTable;
use App\Models\Responsable;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ResponsableResource extends Resource
{
    protected static ?string $model = Responsable::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Responsable';

    /* ==========================================================
     |  VISIBILIDAD EN EL PANEL (MENÚ)
     |==========================================================*/
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()?->isAdmin() === true;
    }

    /* ==========================================================
     |  PERMISOS GLOBALES
     |==========================================================*/
    public static function canViewAny(): bool
    {
        return auth()->user()?->isAdmin() === true;
    }

    public static function canView(Model $record): bool
    {
        return auth()->user()?->isAdmin() === true;
    }

    public static function canCreate(): bool
    {
        return auth()->user()?->isAdmin() === true;
    }

    public static function canEdit(Model $record): bool
    {
        return auth()->user()?->isAdmin() === true;
    }

    public static function canDelete(Model $record): bool
    {
        return auth()->user()?->isAdmin() === true;
    }

    public static function canDeleteAny(): bool
    {
        return auth()->user()?->isAdmin() === true;
    }

    public static function form(Schema $schema): Schema
    {
        return ResponsableForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ResponsablesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListResponsables::route('/'),
            'create' => CreateResponsable::route('/create'),
            'edit' => EditResponsable::route('/{record}/edit'),
        ];
    }
}
