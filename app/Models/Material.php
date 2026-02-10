<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\InvoiceItem;
class Material extends Model
{
    //
     protected $fillable = [ 'name', 'price', 'quantity','status'];
      public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem ::class);
    }
}
