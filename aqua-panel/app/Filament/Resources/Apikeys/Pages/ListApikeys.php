<?php

namespace App\Filament\Resources\Apikeys\Pages;

use App\Filament\Resources\Apikeys\ApikeyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListApikeys extends ListRecords
{
    protected static string $resource = ApikeyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
