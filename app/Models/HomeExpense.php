<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeExpense extends Model
{
    //
    protected $fillable = [ 'amount', 'description', 'date', ];
}
