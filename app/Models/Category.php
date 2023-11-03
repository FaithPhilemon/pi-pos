<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'description'];

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    public function subCategories()
    {
        return $this->hasMany(Category::class, 'sub_category_id');
    }

}
