<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\InvoiceItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function print(Doctor $doctor)
    {
        $items = InvoiceItem::where('doctor_id', $doctor->id)
            ->where('is_archived', false)
            ->with('material')
            ->get();

        $isArchivedMode = false;

        if ($items->isEmpty()) {
            $lastArchivedItem = InvoiceItem::where('doctor_id', $doctor->id)
                ->where('is_archived', true)
                ->latest('updated_at')
                ->first();

            if ($lastArchivedItem) {
                $items = InvoiceItem::where('cycle_code', $lastArchivedItem->cycle_code)
                    ->with('material')
                    ->get();
                $isArchivedMode = true;
            }
        }

        if ($items->isEmpty()) {
            \Filament\Notifications\Notification::make()
                ->title('No Data Available')
                ->body('This doctor has no current or archived transactions to print.')
                ->danger()
                ->send();

            return back();
        }

        $totalItemsPrice = $items->sum('total_price');

        if ($isArchivedMode) {
            $payments = $totalItemsPrice;
            $remainingBalance = 0;
        } else {
            $payments = Payment::where('doctor_id', $doctor->id)
                ->where('created_at', '>=', $items->min('created_at'))
                ->sum('amount');
            $remainingBalance = $doctor->balance;
        }

        $data = [
            'doctor' => $doctor,
            'items' => $items,
            'totalItemsPrice' => $totalItemsPrice,
            'payments' => $payments,
            'remainingBalance' => $remainingBalance,
            'date' => now()->format('d/m/Y'),
            'isArchived' => $isArchivedMode,
        ];

        $fileName = ($isArchivedMode ? 'Archived_' : 'Current_') .
            'Invoice_' . str_replace(' ', '_', $doctor->name) . '.pdf';

        $pdf = Pdf::loadView('invoices.doctor_statement', $data)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->setOptions([
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'defaultFont' => 'sans-serif',
                'margin_top' => 0,
                'margin_bottom' => 0,
                'margin_left' => 0,
                'margin_right' => 0,
            ]);
        ;

        return $pdf->stream($fileName);
    }
}
