<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'date',
        'phone_number',
        'customer_name',
        'store',
        'payment_status',
        'payment_method',
        'total_amount',
        'total_paid',
        'total_items',
        'shipping_status',
        'shipping_details',
        'added_by',
        'staff_note',
        'sale_note',
    ];

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
