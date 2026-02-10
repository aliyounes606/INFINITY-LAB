<?php

namespace App\Filament\Resources\HomeExpenses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HomeExpensesTable
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
                //
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
