<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Idea;
use App\Models\Categoria;

class IdeasCardsStatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        // Tarea 29 de octubre: card para contar ideas por categoría.
        $cTecnologia = Idea::where('categoria_id', 1)->count();
        $cEducacion = Idea::where('categoria_id', 2)->count();
        $cSalud = Idea::where('categoria_id', 3)->count();
        $cMedioAmbiente = Idea::where('categoria_id', 4)->count();
        $cEntretenimiento = Idea::where('categoria_id', 5)->count();

        // Card del total de ideas por estado.
        $registradas = Idea::where('estado', 'registrada')->count();
        $revision = Idea::where('estado', 'en revisión')->count();
        $aprobadas = Idea::where('estado', 'aprobada')->count();
        $rechazadas = Idea::where('estado', 'rechazada')->count();    

        $categorias = Categoria::withCount('ideas')->get();

        $detalleCategorias = '';

        foreach ( $categorias as $categoria) {
            $detalleCategorias .= $categoria->nombre . ': ' . $categoria->ideas_count . ' | ';
        }   

        return [
            // Card del total de ideas por estado.
            Stat::make('Total de ideas', Idea::count())->icon('heroicon-o-light-bulb')
            ->description("Registradas: $registradas | " . "En revisión: $revision | " . "Aprobadas: $aprobadas | " . "Rechizadas: $rechazadas "),  // Tarea 27 de octubre.
            
            // Card Total de categorías.
            Stat::make('Total de categorías', Categoria::count())->icon('heroicon-s-tag')
            ->description($detalleCategorias),

            // Card para contar ideas por categoría (Extra mío).
            //Stat::make('Ideas por categoría', 'Distribución')->icon('heroicon-o-chart-pie')
            //->description("Medio ambiente: $cTecnologia | " . "Salud: $cEducacion | " . "Educación: $cSalud | " . "Medio Ambiente: $cMedioAmbiente | " . "Entretenimiento: $cEntretenimiento "),
        ];
    }

    protected function getColumns(): int {
        return 1;
    }
}
