<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar la fachada Auth

class WelcomeBanner extends StatsOverviewWidget
{
    // Opcional: define que ocupe toda la fila
    protected static ?int $sort = -2; // Para que salga arriba del todo
    protected int | string | array $columnSpan = 'full'; // Ocupa todo el ancho

    protected function getStats(): array
    {

        $user = Auth::user();

        return [
            Stat::make(
                'Bienvenido, ' . $user->nombre,

                'Rol: ' . $user->rol
            )->description('Has accedido al panel de gestión')
             ->color('primary')
             ->icon('heroicon-o-sparkles'),
        ];
    }
}
