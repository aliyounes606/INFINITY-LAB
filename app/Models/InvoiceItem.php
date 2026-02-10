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
        'patient_name',
    ];

    
    protected static function booted()
{
    static::saving(function ($item) {
        // حساب الإجمالي تلقائياً
        $item->total_price = ($item->unit_price * $item->quantity) + ($item->design_price ?? 0);

        // إدارة الـ cycle_code
        if (!$item->cycle_code) {
            $lastActiveItem = self::where('doctor_id', $item->doctor_id)
                ->orderBy('created_at', 'desc')
                ->first();

            if ($item->doctor->balance == 0) {
                $item->cycle_code = 'CYC-' . uniqid();
            } else {
                $item->cycle_code = $lastActiveItem->cycle_code ?? 'CYC-' . uniqid();
            }
        }
    });

    static::created(function ($item) {
        // تحديث رصيد الطبيب
        $item->doctor->increment('balance', $item->total_price);

        // إنقاص المخزون من المادة
        if ($item->material && $item->material->quantity >= $item->quantity) {
            $item->material->decrement('quantity', $item->quantity);
        } else {
            throw new \Exception('Not enough stock available');
        }
    });

    static::updated(function ($item) {
        // تعديل رصيد الطبيب
        $diff = $item->total_price - $item->getOriginal('total_price');
        $item->doctor->increment('balance', $diff);

        // تعديل المخزون إذا تغيرت الكمية
        $oldQty = $item->getOriginal('quantity');
        $newQty = $item->quantity;
        $diffQty = $newQty - $oldQty;

        if ($diffQty > 0) {
            // طلب كمية إضافية → إنقاص المخزون أكثر
            if ($item->material->quantity >= $diffQty) {
                $item->material->decrement('quantity', $diffQty);
            } else {
                throw new \Exception('Not enough stock available');
            }
        } elseif ($diffQty < 0) {
            // قلل الكمية → رجع الفرق للمخزون
            $item->material->increment('quantity', abs($diffQty));
        }
    });

    static::deleted(function ($item) {
        // إنقاص رصيد الطبيب
        $item->doctor->decrement('balance', $item->total_price);

        // رجع الكمية للمخزون إذا انحذف العنصر
        $item->material->increment('quantity', $item->quantity);
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
