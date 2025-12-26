<?php

namespace App\Filament\Resources\Boards\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SensorsRelationManager extends RelationManager
{
    protected static string $relationship = 'sensors';
    protected static ?string $title = 'Sensores';



    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nome')
                    ->placeholder('Relé...')
                    ->required(),
                Select::make('type')
                    ->label('Tipo')
                    ->options([
                        'relay' => 'Relé',
                        'ph' => 'PH',
                        'turbity' => 'Turbidez',
                        'temperature' => 'Temperatura',
                        'humidity' => 'UmidadeDigital',
                        'soil_moisture' => 'Umidade do Solo',
                        'light' => 'Luminosidade',
                        'water_level' => 'Nível da Água',
                        'other' => 'Outro',
                    ])
                    ->label('Tipo')
                    ->placeholder('Selecione...')
                    ->required(),
                TextInput::make('model')
                    ->label('Modelo')
                    ->placeholder('Modelo do sensor...'),
                TextInput::make('port_number')
                    ->label('Numero da porta')
                    ->placeholder('xxx')
                    ->required()
                    ->numeric(),
                Toggle::make('is_analog')
                    ->label('Analogico ?')
                    ->required(),
                TextInput::make('calibration_data')
                    ->label('Dados de calibração (JSON)')
                    ->placeholder('{"offset":0,"scale":1}'),
                Toggle::make('is_active')
                    ->label('Ativo ?')
                    ->required(),
                TextInput::make('unit')
                    ->label('Unidade')
                    ->placeholder('°C, pH, NTU...'),
                TextInput::make('min_value')
                    ->label('Valor mínimo')
                    ->placeholder('xxx')
                    ->numeric(),
                TextInput::make('max_value')
                    ->label('Valor máximo')
                    ->placeholder('xxx')
                    ->numeric(),
                Select::make('status')
                    ->label('Estado atual')
                    ->options([
                        'active' => 'Ativo',
                        'inactive' => 'Inativo',
                        'error' => 'Erro',
                        'maintenance' => 'Manutenção',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nome')
                    ->placeholder('Sensor temp...'),
                TextEntry::make('type'),
                TextEntry::make('model')
                    ->placeholder('-'),
                TextEntry::make('port_number')
                    ->numeric(),
                IconEntry::make('is_analog')
                    ->boolean(),
                IconEntry::make('is_active')
                    ->boolean(),
                TextEntry::make('unit')
                    ->placeholder('-'),
                TextEntry::make('min_value')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('max_value')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('last_error')
                    ->placeholder('-'),
                TextEntry::make('last_calibrated_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('last_read_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label("Nome")
                    ->searchable(),
                TextColumn::make('lastMeasurement.value')
                    ->label("Última leitura")
                    ->sortable(),
                TextColumn::make('type')
                    ->label("Tipo")
                    ->searchable(),
                TextColumn::make('port_number')
                    ->label("Numero da porta")
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label("Ativo")
                    ->boolean(),
                TextColumn::make('last_error')
                    ->label("Último erro")
                    ->placeholder('Erro xxx')
                    ->searchable(),
                TextColumn::make('status')
                    ->label("Estado atual")
                    ->badge(),
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
            ->headerActions([
                CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                \Filament\Actions\ViewAction::make()
                    ->url(fn(\App\Models\Sensor $record): string => \App\Filament\Resources\Sensors\SensorResource::getUrl('view', ['record' => $record])),
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DissociateAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public function isReadOnly(): bool
    {
        return false;
    }
}
