<?php

namespace App\Filament\Resources\Materials\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MaterialsTable
{
    public static function configure(Table $table): Table
    {
        return $table
          

            ->columns([
                TextColumn::make('name')
                    ->label('name')
                    ->searchable(),
                TextColumn::make('price')
                    ->label('price')
                    ->sortable(),
TextColumn::make('quantity')->label('Quantity') ->sortable(),
                BadgeColumn::make('status')
                    ->label('status')
                    ->colors([
                        'success' => 'Available',
                        'danger' => 'Unavailable',
                    ]),

                TextColumn::make('created_at')
                    ->label('created at')
                    ->date(),
            ])

            
            ->filters([
                SelectFilter::make('status')
                    ->label('status')
                    ->options([
                        'Available' => 'Available',
                        ' unavailable' => ' unavailable',
                    ]),
            ])

            ->recordActions([
                // ViewAction::make(),
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
