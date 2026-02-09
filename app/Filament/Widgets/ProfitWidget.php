<?php

namespace App\Filament\Widgets;

use App\Models\Expense;
use App\Models\Payment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProfitWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // Get current month
        $currentMonth = now()->month;

        // Revenue for current month
        $monthlyRevenue = Payment::whereMonth('payment_date', $currentMonth)->sum('amount');

        // Expenses for current month
        $monthlyExpenses = Expense::whereMonth('date', $currentMonth)->sum('amount');

        // Net profit for current month
        $monthlyNetProfit = $monthlyRevenue - $monthlyExpenses;

        return [
            Stat::make('Revenue', $monthlyRevenue)
                ->description('Payments received this month')
                ->color('success')
                ->icon('heroicon-o-currency-dollar'),

            Stat::make('Expenses', $monthlyExpenses)
                ->description('Expenses recorded this month')
                ->color('danger')
                ->icon('heroicon-o-credit-card'),

            Stat::make('Net Profit', $monthlyNetProfit)
                ->description('Revenue minus expenses this month')
                ->color('primary')
                ->icon('heroicon-o-chart-bar'),
                
        Stat::make(' Doctors count', \App\Models\Doctor::count())
            ->description(' All Doctors')
            ->color('primary'),
        ];
    }
}
