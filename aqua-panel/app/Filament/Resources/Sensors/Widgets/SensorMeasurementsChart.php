<?php

namespace App\Filament\Resources\Sensors\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Measurement;
use App\Models\Sensor;
use Carbon\Carbon;
use Filament\Support\RawJs;

class SensorMeasurementsChart extends ChartWidget
{
    protected ?string $heading = 'Gráfico de Medições';

    public ?Sensor $record = null;

    protected ?string $pollingInterval = '1s';


    protected function getData(): array
    {
        if (!$this->record) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $filter = $this->filter;
        $now = Carbon::now();
        $query = Measurement::where('sensor_id', $this->record->id);

        $dateUnit = 'day';

        switch ($filter) {
            case 'today':
                $query->whereDate('created_at', $now->toDateString());
                $dateUnit = 'hour';
                break;
            case 'week':
                $query->whereBetween('created_at', [$now->startOfWeek(), $now->endOfWeek()]);
                $dateUnit = 'day';
                break;
            case 'month':
                $query->whereBetween('created_at', [$now->startOfMonth(), $now->endOfMonth()]);
                $dateUnit = 'day';
                break;
            case 'year':
            default:
                $query->whereYear('created_at', $now->year);
                $dateUnit = 'month';
                break;
        }

        $data = $query->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function ($item) use ($dateUnit) {
                return Carbon::parse($item->created_at)->format($dateUnit === 'hour' ? 'Y-m-d H' : ($dateUnit === 'day' ? 'Y-m-d' : 'Y-m'));
            })
            ->map(function ($group) {
                return $group->avg('value');
            });


        if ($data->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Valor da leitura',
                    'data' => $data->values()->all(),
                    'fill' => 'start',
                ],
            ],
            'labels' => $data->keys()->all(),
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Hoje',
            'week' => 'Semana',
            'month' => 'Mês',
            'year' => 'Ano',
        ];
    }

    public function getDescription(): ?string
    {
        return 'Valores médios das medições do sensor ao longo do tempo.';
    }



    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): RawJs
    {
        return new RawJs(<<<JS
        {
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
            plugins: {
                legend: {
                    display: false,
                },
            },
            elements: {
                line: {
                    borderWidth: 2,
                    tension: 0.4,
                },
                point: {
                    radius: 0,
                    hitRadius: 10,
                    hoverRadius: 4,
                },
            },
            tooltips: {
                mode: 'index',
                intersect: false,
            },
            hover: {
                mode: 'nearest',
                intersect: true
            }
        }
    JS);
    }
}
