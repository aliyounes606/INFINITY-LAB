<?php

namespace App\Filament\Resources\Payments\Schemas;

use App\Models\Doctor;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema

            //
            ->components([
                //  Select::make('invoice_id') ->relationship('invoice', 'invoice_number') ->required(),
                Select::make('doctor_id')->relationship('doctor', 'name')->required(),
                TextInput::make('amount')
                    ->numeric()
                    ->required()
                    ->label('Payment Amount')
                    ->rules([
                        fn($get): \Closure => function (string $attribute, $value, \Closure $fail) use ($get) {
                            $doctorId = $get('doctor_id');
                            if (!$doctorId)
                                return;

                            $doctor = Doctor::find($doctorId);
                            $currentBalance = $doctor?->balance ?? 0;

                            if ($value > $currentBalance) {
                                $fail("Payment failed: The amount exceeds the doctor's current debt ($" . number_format($currentBalance, 2) . ").");
                            }
                        },
                    ]),
                DatePicker::make('payment_date')->required(),
                Textarea::make('notes'),
            ]);

    }
}
