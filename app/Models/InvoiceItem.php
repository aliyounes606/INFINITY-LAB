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
        'shade_id',
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

                // تحديث الحالة إذا صارت الكمية صفر
                if ($item->material->quantity <= 0) {
                    $item->material->status = 'Unavailable';
                    $item->material->save();
                }
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
                if ($item->material->quantity >= $diffQty) {
                    $item->material->decrement('quantity', $diffQty);
                } else {
                    throw new \Exception('Not enough stock available');
                }
            } elseif ($diffQty < 0) {
                $item->material->increment('quantity', abs($diffQty));
            }

            // تحديث الحالة بعد أي تعديل
            if ($item->material->quantity <= 0) {
                $item->material->status = 'Unavailable';
            } else {
                $item->material->status = 'available';
            }
            $item->material->save();
        });

        static::deleted(function ($item) {
            // إنقاص رصيد الطبيب
            $item->doctor->decrement('balance', $item->total_price);

            // رجع الكمية للمخزون إذا انحذف العنصر
            $item->material->increment('quantity', $item->quantity);

            // تحديث الحالة بعد الحذف
            if ($item->material->quantity <= 0) {
                $item->material->status = 'Unavailable';
            } else {
                $item->material->status = 'available';
            }
            $item->material->save();
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

    public function shade()
    {
        return $this->belongsTo(Shade::class);
    }
}
