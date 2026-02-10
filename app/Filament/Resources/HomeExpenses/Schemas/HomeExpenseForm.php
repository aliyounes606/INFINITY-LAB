<?php

namespace App\Filament\Resources\HomeExpenses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class HomeExpenseForm
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
