<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'name',
        'rate',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
