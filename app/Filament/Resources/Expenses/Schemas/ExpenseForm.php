<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('description')
                    ->label('description')
                    ->maxLength(255),

                TextInput::make('amount')
                    ->label('amount')
                    ->numeric()
                    ->required(),

                DatePicker::make('date')
                    ->label('date')
                    ->required(),
            ]);
    }
}
