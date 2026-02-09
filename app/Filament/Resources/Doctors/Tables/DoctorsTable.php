<?php

namespace App\Filament\Resources\Doctors\Tables;

use App\Models\Doctor;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;


class DoctorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->label('Name'),
                TextColumn::make('phone')->label('Phone'),
                TextColumn::make('address')->label('Address'),
                TextColumn::make('balance')
                    ->label('Balance')
                    ->money('USD')
                    ->color('danger'),
            ])
            ->actions([
                Action::make('print_invoice')
                    ->label('Print Statement')
                    ->icon('heroicon-o-printer')
                    ->color('success')
                    // هذا الرابط سيوجهنا لصفحة توليد الـ PDF التي سننشئها
                    ->url(fn(Doctor $record) => route('print.doctor.invoice', ['doctor' => $record->id]))
                    ->openUrlInNewTab(), 
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
