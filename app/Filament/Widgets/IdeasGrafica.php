<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Idea;

class IdeasGrafica extends ChartWidget
{
    protected ?string $heading = 'Ideas Grafica';
    protected static ?int $sort = 2;

    protected function getData(): array
    {

        $registradas = Idea::where('estado', 'registrada')->count();
        $revision = Idea::where('estado', 'en revisión')->count();
        $aprobadas = Idea::where('estado', 'aprobada')->count();
        $rechazadas = Idea::where('estado', 'rechazada')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Estados',
                    'data' => [$registradas, $revision, $aprobadas, $rechazadas],
                    'backgroundColor' =>  ['#3B82F6']    
                ],
            ],
            'labels' => ['Registrada', 'En revisión', 'Aprobada', 'Rechazada'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
