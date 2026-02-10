<?php

namespace App\Filament\Resources\InvoiceItems;

use App\Filament\Resources\InvoiceItems\Pages\CreateInvoiceItem;
use App\Filament\Resources\InvoiceItems\Pages\EditInvoiceItem;
use App\Filament\Resources\InvoiceItems\Pages\ListInvoiceItems;
use App\Filament\Resources\InvoiceItems\Schemas\InvoiceItemForm;
use App\Filament\Resources\InvoiceItems\Tables\InvoiceItemsTable;
use App\Models\InvoiceItem;
use App\Models\Material;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InvoiceItemResource extends Resource
{
    protected static ?string $model = InvoiceItem::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->hasAnyRole('Accountant', 'Admin');
    }
    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)->schema([
                    Select::make('doctor_id')
                        ->label('Doctor')
                        ->options(\App\Models\Doctor::all()->pluck('name', 'id'))
                        ->searchable()
                        ->required(),
                    TextInput::make('patient_name')
                        ->label('Patient Name')
                        ->placeholder('Enter patient full name')
                        ->nullable()
                        ->maxLength(255),


                    Select::make('material_id')
                        ->label('Material / Work Type')
                        ->options(Material::query()->where('status', 'available')->pluck('name', 'id'))
                        ->searchable()
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            $material = Material::find($state);
                            if ($material) {
                                $set('unit_price', $material->price);
                            }
                        })

                        ->required(),
                    // ->columnSpanFull(),
                ]),

                Grid::make(3)->schema([

                    TextInput::make('quantity')
                        ->numeric()
                        ->default(1)
                        ->required()
                        ->reactive()
                        ->label('Qty')
                        ->rules([
                            fn($get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                                $materialId = $get('material_id');
                                if (!$materialId)
                                    return;

                                $material = Material::find($materialId);

                                if (!$material || $material->quantity < $value) {
                                    $fail("Not enough stock available (Current: {$material?->quantity}).");
                                }
                            },
                        ]),

                    TextInput::make('unit_price')
                        ->numeric()
                        ->prefix('$')
                        ->required()
                        ->label('Unit Price'),

                    TextInput::make('design_price')
                        ->numeric()
                        ->prefix('$')
                        ->default(0)
                        ->label('Design Price')
                        ->visible(fn($get) => $get('has_design')),
                ]),

                Toggle::make('has_design')
                    ->label('Include Design?')
                    ->reactive()
                    ->default(false),

                Textarea::make('notes')
                    ->label('Notes (Tooth No, Shade...)')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return \App\Filament\Resources\InvoiceItemResource\Tables\InvoiceItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInvoiceItems::route('/'),
            'create' => CreateInvoiceItem::route('/create'),
            'edit' => EditInvoiceItem::route('/{record}/edit'),
        ];
    }
}
