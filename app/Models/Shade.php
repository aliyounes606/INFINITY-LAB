<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shade extends Model
{
    protected $fillable = [
        'name',
    ];

    public function shade()
    {
        return $this->belongsTo(Shade::class);
    }
}
