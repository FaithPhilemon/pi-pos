<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'store_id',
        'smtp_host',
        'smtp_port',
        'smtp_username',
        'smtp_password',
    ];

    public function store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
}
