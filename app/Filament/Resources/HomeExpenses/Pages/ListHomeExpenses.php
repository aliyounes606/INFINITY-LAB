<?php

namespace App\Filament\Resources\HomeExpenses\Pages;

use App\Filament\Resources\HomeExpenses\HomeExpenseResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHomeExpenses extends ListRecords
{
    protected static string $resource = HomeExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
