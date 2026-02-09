<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    protected $fillable = [
        'invoice_id',
        'doctor_id',
        'amount',
        'payment_date',
        'notes',
    ];
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    //    public function invoice() 
    // { return $this->belongsTo(Invoice::class); }

    protected static function booted()
    {
        // بمجرد إنشاء دفعة جديدة بنجاح
        static::created(function ($payment) {
            $doctor = $payment->doctor;

            //  تنزيل مبلغ الدفعة من رصيد الدكتور
            $doctor->decrement('balance', $payment->amount);

            // التحقق: إذا أصبح الرصيد 0 أو أقل، نغلق الدورة
            if ($doctor->refresh()->balance <= 0) {
                self::archiveCurrentCycle($doctor->id);
            }
        });
    }

    protected static function archiveCurrentCycle($doctorId)
    {
        \App\Models\InvoiceItem::where('doctor_id', $doctorId)
            ->where('is_archived', false)
            ->update(['is_archived' => true]);
    }
}
