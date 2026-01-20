<?php

namespace App\Filament\Resources\Fases;

use App\Filament\Resources\Fases\Pages\CreateFases;
use App\Filament\Resources\Fases\Pages\EditFases;
use App\Filament\Resources\Fases\Pages\ListFases;
use App\Filament\Resources\Fases\Schemas\FasesForm;
use App\Filament\Resources\Fases\Tables\FasesTable;
use App\Models\Fase;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
class FasesResource extends Resource
{
    protected static ?string $model = Fase::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Fases';

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
        return FasesForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FasesTable::configure($table);
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
            'index' => ListFases::route('/'),
            'create' => CreateFases::route('/create'),
            'edit' => EditFases::route('/{record}/edit'),
        ];
    }
}
