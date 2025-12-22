<?php

namespace App\Filament\Resources\Apikeys\Pages;

use App\Filament\Resources\Apikeys\ApikeyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateApikey extends CreateRecord
{
    protected static string $resource = ApikeyResource::class;
}
