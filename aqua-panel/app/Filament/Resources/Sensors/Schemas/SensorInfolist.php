<?php

namespace App\Filament\Resources\Sensors\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SensorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('board.name')
                    ->label('Placa')
                    ->numeric(),
                TextEntry::make('name')
                    ->label('Nome')
                    ->placeholder('Sensor temp...'),
                TextEntry::make('type')
                    ->label('Tipo de sensor')
                    ->placeholder('Relé, temperatura...'),
                TextEntry::make('model')
                    ->label('Modelo')

                    ->placeholder('Adafruit...'),
                TextEntry::make('port_number')
                    ->label('Número da porta')
                    ->placeholder('xxx')
                    ->numeric(),
                IconEntry::make('is_analog')
                    ->label('Analogico ?')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->label('Ativo ?')
                    ->boolean(),
                TextEntry::make('unit')
                    ->label('Unidade de medida')
                    ->placeholder('°C, pH, %...'),
                TextEntry::make('min_value')
                    ->label('Valor mínimo')
                    ->numeric()
                    ->placeholder('1'),
                TextEntry::make('max_value')
                    ->label('Valor máximo')
                    ->placeholder('100')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('last_error')
                    ->label('Último erro')
                    ->placeholder('Erro xxx'),
                TextEntry::make('last_calibrated_at')
                    ->label('Última data de calibração')
                    ->dateTime()
                    ->placeholder('dd/mm/aaaa hh:mm'),
                TextEntry::make('last_read_at')
                    ->label('Última data de leitura')
                    ->dateTime()
                    ->placeholder('dd/mm/aaaa hh:mm'),
                TextEntry::make('status')
                    ->label('Estado atual')
                    ->badge(),
                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->placeholder('dd/mm/aaaa hh:mm'),
                TextEntry::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->placeholder('dd/mm/aaaa hh:mm'),
            ]);
    }
}
