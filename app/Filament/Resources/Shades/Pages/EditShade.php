<?php

namespace App\Filament\Resources\Shades\Pages;

use App\Filament\Resources\Shades\ShadeResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditShade extends EditRecord
{
    protected static string $resource = ShadeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }



}
