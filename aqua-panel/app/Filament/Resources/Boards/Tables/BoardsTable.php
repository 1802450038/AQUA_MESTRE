<?php

namespace App\Filament\Resources\Boards\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BoardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label("Usuario")
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('name')
                    ->label("Nome da Placa")
                    ->searchable(),
                TextColumn::make('uid')
                    ->label("UID da Placa")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('ip_address')
                    ->label("Endereço IP")
                    ->placeholder('xxx.xxx.xxx.xxx')
                    ->searchable(),
                TextColumn::make('apikey.key')
                    ->label("Chave API")
                    ->placeholder('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('location')
                    ->label("Localização")
                    ->searchable(),
                TextColumn::make('wifi_ssid')
                    ->label("SSID WiFi")
                    ->searchable(),
                TextColumn::make('battery_level')
                    ->label("Nível da Bateria")
                    ->numeric()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('last_seen_at')
                    ->label("Último acesso")
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->label("Estado atual")
                    ->badge(),
                TextColumn::make('firmware_version')
                    ->label("Versão Firmware")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('hardware_version')
                    ->label("Versão Hardware")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('last_error')
                    ->label("Último erro")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                TextColumn::make('firmware_file_path')
                    ->label("Caminho do Firmware")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                IconColumn::make('ota_enabled')
                    ->label("OTA Ativado")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->boolean(),
                TextColumn::make('data_interval')
                    ->label("Intervalo de dados (minutos)")
                    ->numeric()
                    ->sortable(),
                TextColumn::make('signal_strength')
                    ->label("Força do Sinal (WiFi)")
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
