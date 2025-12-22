<?php

namespace App\Filament\Resources\Apikeys\Pages;

use App\Filament\Resources\Apikeys\ApikeyResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditApikey extends EditRecord
{
    protected static string $resource = ApikeyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
