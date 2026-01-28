<?php

namespace App\Filament\Widgets;

use App\Models\NotificacionTarea;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    /**
     * SEGURIDAD: Solo lo ven los Responsables que NO son Admins.
     */
    public static function canView(): bool
    {
        $user = auth()->user();
        return $user && $user->responsable !== null && !$user->isAdmin();
    }

    protected function getStats(): array
    {
        $user = auth()->user();
        $responsableId = $user->responsable?->id_responsable;

        // Contamos solo las tareas no leídas asignadas a este responsable específico
        $conteo = NotificacionTarea::whereNull('leido_at')
            ->where('responsable_id', $responsableId)
            ->count();

        return [
            Stat::make('Tareas por revisar', $conteo)
                ->description($conteo > 0 ? 'Tienes entregas pendientes' : '¡Todo al día!')
                ->descriptionIcon($conteo > 0 ? 'heroicon-m-bell-alert' : 'heroicon-m-check-badge')
                ->color($conteo > 0 ? 'danger' : 'success')
                ->chart([3, 5, 2, 7, 4, $conteo]),
        ];
    }
}
