<?php

namespace App\Filament\Widgets;

use App\Models\NotificacionTarea;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    /**
     * SEGURIDAD: Solo permite que el widget se renderice si el
     * usuario logueado tiene un perfil de responsable.
     */
    public static function canView(): bool
    {
        return auth()->user()->responsable !== null;
    }

    protected function getStats(): array
    {
        $user = auth()->user();

        // Obtenemos el ID de responsable vinculado al usuario
        $responsableId = $user->responsable?->id_responsable;

        // Preparamos la consulta base
        $query = NotificacionTarea::whereNull('leido_at');

        // Si es responsable pero NO es admin, solo cuenta sus tareas
        if ($responsableId && ! $user->isAdmin()) {
            $query->where('responsable_id', $responsableId);
        }

        $conteo = $query->count();

        return [
            Stat::make('Tareas por revisar', $conteo)
                ->description($conteo > 0 ? 'Tienes entregas pendientes' : '¡Todo al día!')
                ->descriptionIcon($conteo > 0 ? 'heroicon-m-bell-alert' : 'heroicon-m-check-badge')
                ->color($conteo > 0 ? 'danger' : 'success')
                ->chart([1, 4, 2, 8, 5, $conteo]),
        ];
    }
}
