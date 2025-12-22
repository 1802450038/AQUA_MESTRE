<?php

namespace App\Filament\Resources\Boards\Schemas;

use Dom\Text;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
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
                Hidden::make('user_id')
                    ->default(auth()->id())
                    ->required(),
                TextInput::make('name')
                    ->name('Nome do Dispositivo')
                    ->required(),
                TextInput::make('uid')
                    ->name('UID')
                    ->required(),
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
