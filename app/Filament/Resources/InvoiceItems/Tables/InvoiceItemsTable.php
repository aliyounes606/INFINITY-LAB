<?php

namespace App\Filament\Resources\InvoiceItemResource\Tables;

use App\Models\InvoiceItem;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;

class InvoiceItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            // ->query(InvoiceItem::query()->where('is_archived', false))
            ->query(InvoiceItem::query())
            ->columns([
                TextColumn::make('doctor.name')
                    ->label('Doctor')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('material.name')
                    ->label('Material')
                    ->sortable(),

                TextColumn::make('quantity')
                    ->label('Qty')
                    ->alignCenter(),

                TextColumn::make('unit_price')
                    ->label('Unit Price')
                    ->money('USD'),

                IconColumn::make('has_design')
                    ->label('Design')
                    ->boolean()
                    ->alignCenter(),

                TextColumn::make('total_price')
                    ->label('Total')
                    ->money('USD')
                    ->color('success')
                    ->weight('bold')
                    ->summarize(Sum::make()->label('Total Balance')),

                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('doctor')
                    ->relationship('doctor', 'name')
                    ->label('Filter by Doctor')
                    ->searchable()
                    ->preload(),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        DatePicker::make('from'),
                        DatePicker::make('until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('created_at', '<=', $data['until']));
                    })
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
