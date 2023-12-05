<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id',
        'product_name',
        'price',
        'quantity',
        'total',
    ];


    protected static function booted()
    {
        static::created(function ($saleItem) {
            $saleItem->updateSale();
        });

        static::updated(function ($saleItem) {
            $saleItem->updateSale();
        });

        static::deleted(function ($saleItem) {
            $saleItem->updateSale();
        });
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function updateSale()
    {
        // Logic to update the related Sale
        $this->sale->updateSaleTotals();
    }

}
