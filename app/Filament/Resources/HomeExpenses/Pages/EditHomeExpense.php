<?php

namespace App\Filament\Resources\HomeExpenses\Pages;

use App\Filament\Resources\HomeExpenses\HomeExpenseResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditHomeExpense extends EditRecord
{
    protected static string $resource = HomeExpenseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
        
    }   protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
