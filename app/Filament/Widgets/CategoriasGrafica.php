<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Idea;   


class CategoriasGrafica extends ChartWidget
{
    protected ?string $heading = 'Categorias Grafica';
    protected static ?int $sort = 3;

    protected function getData(): array
    {

        $cTecnologia = Idea::where('categoria_id', 1)->count();
        $cEducacion = Idea::where('categoria_id', 2)->count();
        $cSalud = Idea::where('categoria_id', 3)->count();
        $cMedioAmbiente = Idea::where('categoria_id', 4)->count();
        $cEntretenimiento = Idea::where('categoria_id', 5)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Ideas por categoría',
                    'data' => [$cTecnologia, $cEducacion, $cSalud, $cMedioAmbiente, $cEntretenimiento],
                    'backgroundColor' =>  ['#FF0000', '#00FF00', '#0000FF', '#FFFF00', '#FF00FF']   
                ],
            ],
            'labels' => ['Tecnología', 'Educacion', 'Salud', 'Medio Ambiente', 'Entretenimiento'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
