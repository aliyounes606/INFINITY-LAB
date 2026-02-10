<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use App\Models\Expense;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class MonthlyProfitChart extends ChartWidget
{
    protected ?string $heading = 'Monthly Net Profit';
    protected int|string|array $columnSpan = '1/2';

    protected function getData(): array
    {
        // Revenue grouped by month (using payment_date)
        $monthlyRevenue = Payment::selectRaw('MONTH(payment_date) as month, SUM(amount) as revenue')
            ->whereYear('payment_date', now()->year)
            ->groupBy('month')
            ->pluck('revenue', 'month');

        // Expenses grouped by month (using date)
        $monthlyExpenses = Expense::selectRaw('MONTH(date) as month, SUM(amount) as expenses')
            ->whereYear('date', now()->year)
            ->groupBy('month')
            ->pluck('expenses', 'month');

        $labels = [];
        $profits = [];

        foreach (range(1, 12) as $month) {
            $labels[] = Carbon::create()->month($month)->format('F'); // January, February, ...
            $revenue = $monthlyRevenue[$month] ?? 0;
            $expenses = $monthlyExpenses[$month] ?? 0;
            $profits[] = $revenue - $expenses;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Net Profit',
                    'data' => $profits,
                    'backgroundColor' => '#42A5F5',
                    'borderColor' => '#1E88E5',
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // Bar chart
    }
    public static function canView(): bool { return auth()->user()->hasRole('Admin'); }
}
