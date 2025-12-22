<?php

namespace App\Filament\Resources\Apikeys\Pages;

use App\Filament\Resources\Apikeys\ApikeyResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewApikey extends ViewRecord
{
    protected static string $resource = ApikeyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
