<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'doctor_id',
        'material_id',
        'quantity',
        'unit_price',
        'total_price',
        'notes',
        'has_design',
        'design_price',
        'cycle_code',
    ];

    protected static function booted()
    {
        static::saving(function ($item) {
            //  حساب الإجمالي تلقائياً
            $item->total_price = ($item->unit_price * $item->quantity) + ($item->design_price ?? 0);

            //  إدارة الـ cycle_code (نظام الدورة المالية)
            // إذا كان الدكتور رصيده 0، نولد كود جديد، وإلا نستخدم الكود الحالي
            if (!$item->cycle_code) {
                $lastActiveItem = self::where('doctor_id', $item->doctor_id)
                    ->orderBy('created_at', 'desc')
                    ->first();

                // إذا كان رصيد الدكتور صفر (دورة جديدة)
                if ($item->doctor->balance == 0) {
                    $item->cycle_code = 'CYC-' . uniqid();
                } else {
                    $item->cycle_code = $lastActiveItem->cycle_code ?? 'CYC-' . uniqid();
                }
            }
        });

        static::created(function ($item) {
            //  تحديث رصيد الطبيب فوراً 
            $item->doctor->increment('balance', $item->total_price);
        });
        static::updated(function ($item) {
            // نحسب الفرق بين القيمة الجديدة والقيمة القديمة
            $diff = $item->total_price - $item->getOriginal('total_price');

            // نعدل رصيد الطبيب بناءً على الفرق (زيادة أو نقصان)
            $item->doctor->increment('balance', $diff);
        });

        static::deleted(function ($item) {
            //  في حال حذف قطعة، ينقص الرصيد تلقائياً
            $item->doctor->decrement('balance', $item->total_price);
        });
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
