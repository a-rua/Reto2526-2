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

        // CORRECCIÓN: Usamos id_usuario porque es lo que guarda tu tabla notificacion_tareas
        $idUsuarioAlumno = $user->id_usuario;

        // 1. Tareas que el alumno ha entregado
        $tareasEntregadas = NotificacionTarea::where('alumno_id', $idUsuarioAlumno)->count();

        // 2. Tareas que el profesor ya ha marcado como leídas/revisadas
        $tareasRevisadas = NotificacionTarea::where('alumno_id', $idUsuarioAlumno)
            ->whereNotNull('leido_at')
            ->count();

        // 3. Tareas enviadas que aún no han sido revisadas (Pendientes)
        $pendientesRevision = NotificacionTarea::where('alumno_id', $idUsuarioAlumno)
            ->whereNull('leido_at')
            ->count();

        return [
            Stat::make('Mis Entregas', $tareasEntregadas)
                ->description('Total de tareas enviadas')
                ->descriptionIcon('heroicon-m-paper-airplane')
                ->color('info')
                ->url(route('filament.dashboard.resources.notificacion-tareas.index')), // Opcional: enlace a sus entregas

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
