<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'state',
        'address',
        'phone_number',
        'email',
        'logo',
        'icon',
    ];
}
