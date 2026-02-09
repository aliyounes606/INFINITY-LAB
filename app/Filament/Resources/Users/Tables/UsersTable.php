<?php

namespace App\Filament\Resources\Users\Tables;

use Filament\Actions\EditAction;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email'),
                Tables\Columns\TextColumn::make('roles.name')
                    ->label('Role')
                    ->badge(),
            ])
            ->actions([
                EditAction::make(),
                \Filament\Actions\DeleteAction::make()
                    ->hidden(fn($record) => $record->hasRole('Admin')),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make()
                        ->before(function (\Illuminate\Support\Collection $records) {
                            foreach ($records as $record) {
                                if ($record->hasRole('Admin')) {
                                    \Filament\Notifications\Notification::make()
                                        ->title('System Protection')
                                        ->body('One or more selected users are Administrators and cannot be deleted.')
                                        ->danger()
                                        ->send();

                                    throw new \Exception('Admin detected in selection.');
                                }
                            }
                        }),
                ]),
            ]);
    }
}
