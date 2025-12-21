<?php

namespace App\Filament\Resources\Sensors\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SensorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('board_id')
                    ->required()
                    ->numeric(),
                TextInput::make('name')
                    ->required(),
                TextInput::make('type')
                    ->required(),
                TextInput::make('model'),
                TextInput::make('port_number')
                    ->required()
                    ->numeric(),
                Toggle::make('is_analog')
                    ->required(),
                TextInput::make('calibration_data'),
                Toggle::make('is_active')
                    ->required(),
                TextInput::make('unit'),
                TextInput::make('min_value')
                    ->numeric(),
                TextInput::make('max_value')
                    ->numeric(),
                TextInput::make('last_error'),
                DateTimePicker::make('last_calibrated_at'),
                DateTimePicker::make('last_read_at'),
                Select::make('status')
                    ->options([
            'active' => 'Active',
            'inactive' => 'Inactive',
            'error' => 'Error',
            'maintenance' => 'Maintenance',
        ])
                    ->default('active')
                    ->required(),
            ]);
    }
}
