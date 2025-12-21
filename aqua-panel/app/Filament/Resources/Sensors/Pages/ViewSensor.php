<?php

namespace App\Filament\Resources\Sensors\Pages;

use App\Filament\Resources\Sensors\SensorResource;
use App\Filament\Resources\Sensors\Widgets\SensorMeasurementsChart;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSensor extends ViewRecord
{
    protected static string $resource = SensorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            SensorMeasurementsChart::class,
        ];
    }
}
