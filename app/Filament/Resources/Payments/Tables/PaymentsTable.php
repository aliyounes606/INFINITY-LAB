<?php

namespace App\Filament\Resources\Payments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                //
               TextColumn::make('doctor.name') ->label('Doctor') ->sortable() ->searchable(),
                TextColumn::make('amount') ->label('Amount') ->sortable(), 
                TextColumn::make('payment_date') ->date() ->label('Date') ->sortable(), 
                TextColumn::make('notes') ->label('Notes') ->limit(30), 
            ])
            ->filters([
             SelectFilter::make('doctor_id') ->relationship('doctor', 'name') ->label('Doctor'),
            ])
            ->recordActions([
              ViewAction::make(),
                EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
