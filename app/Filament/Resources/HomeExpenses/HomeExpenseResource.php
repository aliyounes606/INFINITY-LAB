<?php

namespace App\Filament\Resources\HomeExpenses;

use App\Filament\Resources\HomeExpenses\Pages\CreateHomeExpense;
use App\Filament\Resources\HomeExpenses\Pages\EditHomeExpense;
use App\Filament\Resources\HomeExpenses\Pages\ListHomeExpenses;
use App\Filament\Resources\HomeExpenses\Schemas\HomeExpenseForm;
use App\Filament\Resources\HomeExpenses\Tables\HomeExpensesTable;
use App\Models\HomeExpense;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class HomeExpenseResource extends Resource
{
    protected static ?string $model = HomeExpense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'amount';
    public static function shouldRegisterNavigation(): bool 
     { return auth()->user()->hasRole('Admin'); }
    public static function form(Schema $schema): Schema
    {
        return HomeExpenseForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HomeExpensesTable::configure($table);
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
            'index' => ListHomeExpenses::route('/'),
            'create' => CreateHomeExpense::route('/create'),
            'edit' => EditHomeExpense::route('/{record}/edit'),
        ];
    }
}
