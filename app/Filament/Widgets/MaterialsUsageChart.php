<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Material;

class MaterialsUsageChart extends ChartWidget
{
    protected ?string $heading = ' Materials Usage Chart';
protected int|string|array $columnSpan = '1/2';
    protected function getData(): array
    {
        // جلب المواد مع عدد مرات استخدامها في الفواتير
        $materials = Material::withCount('invoiceItems')->get();

        return [
            'datasets' => [
                ['label' => 'Materials Usage Chart  ',
                  'borderColor' => '#b7beb7',
                
                    'data' => $materials->pluck('invoice_items_count')->toArray(),
                    'backgroundColor' => ['#42A5F5', '#66BB6A', '#FFA726', '#AB47BC', '#EF5350'],
                ],
            ],
             'labels' => $materials->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
