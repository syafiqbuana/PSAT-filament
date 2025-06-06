<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Car;

class CarStatusChart extends ChartWidget
{
    protected static ?string $heading = 'Car Status';

    protected function getData(): array
    {
        $available = Car::where('status', 'available')->count();
        $sold = Car::where('status', 'sold')->count();
        return [
            'datasets' => [
                [
                    'label' => 'Car Status',
                    'data' => [$available, $sold],
                    'backgroundColor' => ['#4CAF50', '#F44336'], // Green for available, Red for sold
                ],
            ],
            'labels' => ['Available', 'Sold'],
            
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
    protected function getMaxHeight(): ?string
    {
        return '190px'; // Samakan dengan CarSalesChart
    }
}
