<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        // Fetch product details (name, image, category, price)
        $products = Product::with('category') // Assuming a relationship exists between Product and Category
            ->select('id', 'name', 'image', 'category_id', 'price')
            ->get();

        return view('sales.pos', compact('products'));
    }
}
