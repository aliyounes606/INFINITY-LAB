<?php

namespace App\Filament\Resources\Shades;
use App\Filament\Resources\Shades\Pages\CreateShade;
use App\Filament\Resources\Shades\Pages\EditShade;
use App\Filament\Resources\Shades\Pages\ListShades;
use App\Models\Shade;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use BackedEnum;

class ShadeResource extends Resource
{
    protected static ?string $model = Shade::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationLabel = 'Shades';
    protected static ?int $navigationSort = 3;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole('Material Manager', 'Accountant', 'Admin');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(1)->schema([
                    TextInput::make('name')
                        ->label('Shade Code')
                        ->placeholder('e.g. A1, B2, BL3')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Shade Code')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShades::route('/'),
            'create' => CreateShade::route('/create'),
            'edit' => EditShade::route('/{record}/edit'),
        ];
    }
}