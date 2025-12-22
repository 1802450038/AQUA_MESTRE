<?php

namespace App\Filament\Resources\Sensors;

use App\Filament\Resources\Sensors\Pages\CreateSensor;
use App\Filament\Resources\Sensors\Pages\EditSensor;
use App\Filament\Resources\Sensors\Pages\ListSensors;
use App\Filament\Resources\Sensors\Pages\ViewSensor;
use App\Filament\Resources\Sensors\Schemas\SensorForm;
use App\Filament\Resources\Sensors\Schemas\SensorInfolist;
use App\Filament\Resources\Sensors\Tables\SensorsTable;
use App\Models\Sensor;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SensorResource extends Resource
{
    protected static ?string $model = Sensor::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return SensorForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SensorInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SensorsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\MeasurementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSensors::route('/'),
            'create' => CreateSensor::route('/create'),
            'view' => ViewSensor::route('/{record}'),
            'edit' => EditSensor::route('/{record}/edit'),
        ];
    }
}
