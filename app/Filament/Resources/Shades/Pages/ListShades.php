<?php

namespace App\Filament\Resources\Shades\Pages;

use App\Filament\Resources\Shades\ShadeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListShades extends ListRecords
{
    protected static string $resource = ShadeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
