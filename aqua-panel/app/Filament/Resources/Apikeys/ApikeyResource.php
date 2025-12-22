<?php

namespace App\Filament\Resources\Apikeys;


use App\Filament\Resources\Apikeys\Pages\CreateApikey;
use App\Filament\Resources\Apikeys\Pages\EditApikey;
use App\Filament\Resources\Apikeys\Pages\ListApikeys;
use App\Filament\Resources\Apikeys\Pages\ViewApikey;
use App\Filament\Resources\Apikeys\Schemas\ApikeyForm;
use App\Filament\Resources\Apikeys\Schemas\ApikeyInfolist;
use App\Filament\Resources\Apikeys\Tables\ApikeysTable;
use App\Models\Apikey;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ApikeyResource extends Resource
{
    protected static ?string $model = Apikey::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'key';

    public static function form(Schema $schema): Schema
    {
        return ApikeyForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ApikeyInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ApikeysTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListApikeys::route('/'),
            'create' => CreateApikey::route('/create'),
            'view' => ViewApikey::route('/{record}'),
            'edit' => EditApikey::route('/{record}/edit'),
        ];
    }
}
