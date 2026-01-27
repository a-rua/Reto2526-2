<?php

namespace App\Filament\Widgets;

use App\Models\NotificacionTarea;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AlumnoStatsOverview extends BaseWidget
{
    /**
     * SEGURIDAD: Solo lo ven los usuarios que tienen perfil de alumno.
     */
    public static function canView(): bool
    {
        return auth()->check() && auth()->user()->isAlumno();
    }

    protected function getStats(): array
    {
        $user = auth()->user();

        // Obtenemos el ID de la relación alumno
        $idAlumno = $user->alumno?->id_alumno;

        // 1. Tareas que el alumno ha entregado (están en la tabla de notificaciones)
        $tareasEntregadas = NotificacionTarea::where('alumno_id', $idAlumno)->count();

        // 2. Tareas que el profesor ya ha marcado como leídas/revisadas
        $tareasRevisadas = NotificacionTarea::where('alumno_id', $idAlumno)
            ->whereNotNull('leido_at')
            ->count();

        // 3. Tareas enviadas que aún no han sido revisadas
        $pendientesRevision = $tareasEntregadas - $tareasRevisadas;

        return [
            Stat::make('Mis Entregas', $tareasEntregadas)
                ->description('Total de tareas enviadas')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('info'),

            Stat::make('Tareas Revisadas', $tareasRevisadas)
                ->description('Feedback del profesor listo')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),

            Stat::make('Pendientes de Revisión', $pendientesRevision)
                ->description('Esperando corrección')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendientesRevision > 0 ? 'warning' : 'gray'),
        ];
    }
}
