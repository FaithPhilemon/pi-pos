<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_prefix',
        'supplier_prefix',
        'customer_prefix',
        'sale_prefix',
        'purchase_prefix',
        'currency',
        'currency_symbol',
        'enable_payments',
    ];
}
