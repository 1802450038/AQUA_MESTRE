<?php

namespace App\Filament\Resources\Boards\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BoardForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->default(auth()->id())
                    ->required(),
                TextInput::make('name')
                    ->name('Nome do Dispositivo')
                    ->required(),
                TextInput::make('uid')
                    ->name('UID')
                    ->required(),
                // TextInput::make('api_key')
                //     ->name('API Key')
                //     ->required(),

                TextInput::make('location')
                    ->name('Localização'),
                TextInput::make('data_interval')
                    ->name('Intervalo de Dados')
                    ->label('Intervalo de Dados (min)')
                    ->required()
                    ->numeric()
                    ->default(5),
            ]);
    }
}
