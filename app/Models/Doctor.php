<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'balance',
        'address',
    ];
    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
