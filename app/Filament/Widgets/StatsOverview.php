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

    // Usamos directamente el ID del usuario, que es lo que espera 'responsable_id'
    // según tu migración: $table->foreignId('responsable_id')->constrained('usuarios', 'id_usuario')
    $conteo = NotificacionTarea::where('responsable_id', $user->id_usuario)
        ->whereNull('leido_at')
        ->count();

    return [
        Stat::make('Tareas por revisar', $conteo)
            ->description($conteo > 0 ? 'Tienes entregas pendientes' : '¡Todo al día!')
            ->descriptionIcon($conteo > 0 ? 'heroicon-m-bell-alert' : 'heroicon-m-check-badge')
            ->color($conteo > 0 ? 'danger' : 'success')
            // Opcional: Si quieres que el gráfico sea dinámico podrías pasar un histórico,
            // pero para un contador simple, esto está bien.
            ->chart([7, 4, $conteo]),
    ];
}
}
