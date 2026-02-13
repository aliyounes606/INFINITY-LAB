<?php

namespace App\Filament\Resources\Materials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),

                TextColumn::make('price')
                    ->label('Price')
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    // ->colors([
                    //     'success' => 'available',
                    //     'danger' => 'unavailable',
                    // ])
                    ->colors([
    'success' => 'available',
    'danger' => 'Unavailable',
])
->formatStateUsing(fn ($state) => ucfirst($state)),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->date(),
            ])

            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'available' => 'Available',
                        'Unavailable' => 'Unavailable',
                    ]),
            ])

            ->recordActions([
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
