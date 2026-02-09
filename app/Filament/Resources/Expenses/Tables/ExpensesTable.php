<?php

namespace App\Filament\Resources\Expenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Summarizers\Sum;

class ExpensesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('description')
                    ->label('description')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('amount')
                    ->label('amount')
                    ->numeric()
                    ->sortable()
                    ->summarize(Sum::make()), 

                TextColumn::make('date')
                    ->label(' date')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
       
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
