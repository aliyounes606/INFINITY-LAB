<?php

namespace App\Filament\Resources\HomeExpenses\Pages;

use App\Filament\Resources\HomeExpenses\HomeExpenseResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHomeExpense extends CreateRecord
{
    protected static string $resource = HomeExpenseResource::class;
      protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
