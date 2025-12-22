<?php

namespace App\Filament\Resources\Boards\RelationManagers;

use App\Filament\Resources\Apikeys\ApikeyResource;
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
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ApiKeysRelationManager extends RelationManager
{
    protected static string $relationship = 'apiKeys';

    protected static ?string $title = 'Chave API';

    // protected static ?string $relatedResource = ApikeyResource::class;



    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('board_id')
                ->default(fn ($livewire) => $livewire->getOwnerRecord()->getKey()),
                Hidden::make('user_id')
                ->default(auth()->id())
                ->required(),
            ]);
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('key')
                    ->label('Chave')
                    ->placeholder('Chave api xxx...'),
                TextEntry::make('is_active')
                    ->label('Ativo ?')
                    ->boolean(),
                TextEntry::make('user_id')
                    ->placeholder('-'),
                TextEntry::make('board_id')
                    ->placeholder('-'),
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
            ->recordTitleAttribute('key')
            ->columns([
                TextColumn::make('key')
                    ->label("Chave")
                    ->searchable(),
                ToggleColumn::make('is_active')
                    ->label("Ativo"),
                TextColumn::make('user_id')
                    ->label("Dono da chave")
                    ->placeholder('xxx')
                    ->searchable(),
                TextColumn::make('board_id')
                    ->label("Placa")
                    ->placeholder('xxx')
                    ->searchable(),
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
                CreateAction::make()
                ->visible(fn () => ! $this->getOwnerRecord()->apiKeys()->exists()),
            ])
            ->recordActions([
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
