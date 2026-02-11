<?php

namespace App\Filament\Resources\Shades\Pages;

use App\Filament\Resources\Shades\ShadeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateShade extends CreateRecord
{
    protected static string $resource = ShadeResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
