<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use App\Models\Sales;
use Flowframe\Trend\TrendValue;
use Carbon\Carbon;


class CarSalesChart extends ChartWidget
{
    protected static ?string $heading = 'Car Sales ';

    protected function getData(): array
    {
        $data = Trend::model(Sales::class)
        ->dateColumn('sale_date')
            ->between(
                start:now()->startOfYear(),
                end:now()->endOfYear()
            )
            ->perMonth()
            ->count();
           
       
        return [
            'datasets'=>[
                [
                    'label'=>'Car Sales ',
                    'data'=>$data->map(fn(TrendValue $value) => $value->aggregate),
                ],

            ],
            'labels'=> $data->map(function (TrendValue $value){
                $date = Carbon::createFromFormat('Y-m', $value->date);
                $formattedDate = $date->format('M ');
                return $formattedDate;
            })
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
