<?php

namespace App\Filament\Resources\NotificacionTareas;

use App\Filament\Resources\NotificacionTareas\Pages\CreateNotificacionTarea;
use App\Filament\Resources\NotificacionTareas\Pages\EditNotificacionTarea;
use App\Filament\Resources\NotificacionTareas\Pages\ListNotificacionTareas;
use App\Models\NotificacionTarea;
use App\Models\Usuario;
use App\Models\Tarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use BackedEnum;

class NotificacionTareaResource extends Resource
{
    protected static ?string $model = NotificacionTarea::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Notificaciones de Tareas';

public static function canViewAny(): bool
    {
        return auth()->user()->responsable !== null;
    }

    /**
     * FILTRO DE DATOS: El responsable solo verá las notificaciones
     * dirigidas a él (donde responsable_id sea su ID de responsable).
     */
    public static function getEloquentQuery(): Builder
    {
        $user = auth()->user();
        $query = parent::getEloquentQuery();

        // Si es responsable pero NO es admin, filtramos por su ID
        if ($user->responsable && ! $user->isAdmin()) {
            return $query->where('responsable_id', $user->responsable->id_responsable);
        }

        // Si es Admin, lo dejamos ver todas
        return $query;
    }

    // ... (el resto de tus métodos form y table se mantienen igual)

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Usamos la resolución de componentes de Filament para evitar errores de Namespace
             Section::make('Detalles de la Entrega')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('alumno_id')
                            ->label('Alumno')
                            ->formatStateUsing(fn ($state) => Usuario::find($state)?->nombre ?? 'Desconocido')
                            ->disabled(),

                        \Filament\Forms\Components\TextInput::make('id_tarea')
                            ->label('Tarea Entregada')
                            ->formatStateUsing(fn ($state) => Tarea::find($state)?->nombre ?? 'Sin nombre')
                            ->disabled(),

                        \Filament\Forms\Components\Textarea::make('comentario')
                            ->label('Comentario del Alumno')
                            ->rows(3)
                            ->columnSpanFull()
                            ->disabled(),

                        \Filament\Forms\Components\DateTimePicker::make('leido_at')
                            ->label('Fecha de Revisión')
                            ->native(false),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('alumno.nombre')
                    ->label('Alumno')
                    ->sortable(),
                TextColumn::make('tarea.nombre')
                    ->label('Tarea'),
                TextColumn::make('created_at')
                    ->label('Fecha entrega')
                    ->dateTime('d/m/Y H:i'),
                IconColumn::make('leido_at')
                    ->label('Revisado')
                    ->boolean()
                    ->getStateUsing(fn ($record) => filled($record->leido_at)),
            ])
            ->actions([
                Action::make('marcarLeido')
                    ->label('Marcar leído')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->action(fn ($record) => $record->update(['leido_at' => now()]))
                    ->hidden(fn ($record) => filled($record->leido_at)),
                EditAction::make(),

                DeleteAction::make()
                    ->label('Eliminar'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListNotificacionTareas::route('/'),
            'create' => CreateNotificacionTarea::route('/create'),
            'edit' => EditNotificacionTarea::route('/{record}/edit'),
        ];
    }
}
