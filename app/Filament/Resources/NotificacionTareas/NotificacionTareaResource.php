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
use BackedEnum;
// ... (tus otros imports se mantienen)
use Illuminate\Database\Eloquent\Builder;
class NotificacionTareaResource extends Resource
{
    protected static ?string $model = NotificacionTarea::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Notificaciones de Tareas';
    /**
     * SEGURIDAD: Solo los usuarios que son "Responsables" pueden ver este recurso.
     */
    public static function canViewAny(): bool
    {
        $user = auth()->user();
        return $user && ($user->responsable !== null || $user->isAdmin());
    }

    /**
     * FILTRO: El responsable solo ve las tareas de las que él es responsable.
     */
  public static function getEloquentQuery(): Builder
{
    $user = auth()->user();
    $query = parent::getEloquentQuery();

    // El responsable debe ver las tareas donde su id_usuario coincida con responsable_id
    if ($user->responsable && !$user->isAdmin()) {
        return $query->where('responsable_id', $user->id_usuario);
    }

    return $query;
}


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

                       \Filament\Forms\Components\Textarea::make('comentario') // Debe llamarse igual que en el modelo/DB
                        ->label('Comentario del Alumno')
                        ->rows(3)
                        ->columnSpanFull()
                        ->disabled(), // Lo mantenemos disabled para que el responsable no lo edite

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
               TextColumn::make('alumno_usuario.nombre')
    ->label('Alumno')
    ->searchable(),
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
