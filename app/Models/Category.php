<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;


class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'parent_category_id', 'description'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // public function subCategory()
    // {
    //     return $this->belongsTo(Category::class, 'sub_category_id');
    // }

     // Relationship to parent category
     public function parentCategory()
     {
         return $this->belongsTo(Category::class, 'parent_category_id');
     }
 
     // Relationship to subcategories
     public function subcategories()
     {
        //  return $this->hasMany(Category::class, 'sub_category_id');
         return $this->hasMany(Category::class, 'parent_category_id');
     }

}
