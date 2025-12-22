<?php

namespace App\Filament\Resources\Boards\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class BoardInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('Proprietário'),
                TextEntry::make('name')
                    ->label('Nome do Dispositivo'),
                TextEntry::make('uid')
                    ->label('UID'),
                TextEntry::make('ip_address')
                    ->label('Endereço IP')
                    ->placeholder('xxx.xxx.xxx.xxx'),
                TextEntry::make('location')
                    ->label('Localização')
                    ->placeholder('Nome do local...'),
                TextEntry::make('wifi_ssid')
                    ->placeholder('Nome da Rede Wifi'),
                TextEntry::make('battery_level')
                    ->numeric()
                    ->placeholder('xxx%'),
                TextEntry::make('last_seen_at')
                    ->label('Última conexão')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->label('Estado atual')
                    ->badge(),
                TextEntry::make('firmware_version')
                    ->label('Versão Firmware')
                    ->placeholder('Vx.x'),
                TextEntry::make('hardware_version')
                    ->label('Versão Hardware')
                    ->placeholder('Vx.x'),
                TextEntry::make('last_error')
                    ->label('Último erro')
                    ->placeholder('Erro xxx'),
                TextEntry::make('firmware_file_path')
                    ->placeholder('-'),
                IconEntry::make('ota_enabled')
                    ->label('Atualização sem fio habilitada')
                    ->boolean(),
                TextEntry::make('data_interval')
                    ->label('Intervalo de envio dos dados (min)')
                    ->numeric(),
                TextEntry::make('signal_strength')
                    ->label('Força da conexão WIFI')
                    ->numeric()
                    ->placeholder('-XXdbi'),
                TextEntry::make('created_at')
                    ->label('Criado em')
                    ->dateTime()
                    ->placeholder('mm/dd/yyyy hh:mm'),
                TextEntry::make('updated_at')
                    ->label('Atualizado em')
                    ->dateTime()
                    ->placeholder('mm/dd/yyyy hh:mm'),
            ]);
    }
}
