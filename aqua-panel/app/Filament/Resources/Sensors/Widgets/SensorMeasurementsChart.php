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

    protected ?string $pollingInterval = '5s';

    protected int | string | array $columnSpan = 'full';


    protected function getData(): array
    {
        if (!$this->record) {
            return ['datasets' => [], 'labels' => []];
        }

        $filter = $this->filter;
        $query = Measurement::where('sensor_id', $this->record->id);

        // Variável para controlar se devemos agrupar ou não
        $isRawData = false;

        switch ($filter) {
            case 'hour':
                // Pega dados da última hora (ex: das 14:00 às 14:59 se agora for 14:30)
                // Ou se preferir "últimos 60 minutos": Carbon::now()->subHour()
                $query->where('created_at', '>=', Carbon::now()->subHour());
                $isRawData = true; // Exibir cada ponto individualmente
                break;

            case 'today':
                $query->whereDate('created_at', Carbon::today());
                $isRawData = true; // Exibir cada ponto individualmente
                break;

            case 'week':
                $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                $dateFormat = 'd/m - H:00'; // Agrupa por hora
                break;

            case 'month':
                $query->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                $dateFormat = 'd/m'; // Agrupa por dia
                break;

            case 'year':
            default:
                $query->whereYear('created_at', Carbon::now()->year);
                $dateFormat = 'm/Y'; // Agrupa por mês
                break;
        }

        // Recupera os dados ordenados
        $measurements = $query->orderBy('created_at', 'asc')->get();

        if ($isRawData) {
            // LÓGICA SEM AGRUPAMENTO (Ponto a Ponto)
            // Ideal para "Hora" e "Hoje"
            $labels = $measurements->map(fn($item) => $item->created_at->format('H:i:s'))->all();
            $values = $measurements->pluck('value')->all();
        } else {
            // LÓGICA COM AGRUPAMENTO (Média)
            // Necessário para períodos longos (Mês/Ano) para não travar o navegador com milhares de pontos
            $grouped = $measurements->groupBy(function ($item) use ($dateFormat) {
                return Carbon::parse($item->created_at)->format($dateFormat);
            });

            $labels = $grouped->keys()->all();
            $values = $grouped->map(fn($group) => round($group->avg('value'), 2))->values()->all();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Valor da Leitura',
                    'data' => $values,
                    'fill' => true,
                    'borderColor' => '#4ade80',
                    'pointRadius' => 3, // Aumentei um pouco o ponto para ficar visível cada leitura
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getFilters(): ?array
    {
        return [
            'hour' => 'Última Hora',
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
        return 'line';
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
