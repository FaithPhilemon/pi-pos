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
        'sale_status_id',
        'payment_status_id',
        'payment_method_id',
        'total_amount',
        'total_paid',
        'discount',
        'total_items',
        'shipping_status_id',
        'shipping_details',
        'added_by',
        'staff_note',
        'sale_note',
    ];


    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function updateSaleTotals()
    {
        $this->total_amount = $this->saleItems()->sum('total');
        $this->total_paid   = $this->calculateDiscount($this->saleItems()->sum('total'), $this->discount);
        $this->total_items  = $this->saleItems()->sum('quantity');
        $this->save();
    }


    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }


    public function saleStatus()
    {
        return $this->belongsTo(SaleStatus::class, 'sale_status_id');
    }


    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }


    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }

    
    public function shippingStatus()
    {
        return $this->belongsTo(ShippingStatus::class, 'shipping_status_id');
    }

    private function calculateDiscount($price, $percentage){
        return $price - ($price * ($percentage/100));
    }
}
