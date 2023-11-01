<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'twilio_from',
        'twilio_sid',
        'twilio_token',
        'api_key',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
