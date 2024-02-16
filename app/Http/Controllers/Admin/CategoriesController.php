<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    public function index()
    {
        $this->authorize('view categories');
        $categories = Category::all();
        return view('products.categories', compact('categories'));
    }

    public function subIndex(Request $request)
    {
        // Retrieve subcategories based on the provided category_id
        $category_id = $request->input('category_id');
        
        if ($category_id) {
            $category = Category::with('subcategories')->find($category_id);
            return response()->json($category->subcategories);
        }

        return response()->json([]);
    }

    public function create()
    {
        $this->authorize('create categories');
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create categories');

        // Validation rules for category data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'nullable',
            'parent_category_id' => 'nullable',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('categories.create')->withErrors($validator)->withInput();
        }

        // Create the category
        Category::create($request->all());

        return redirect()->route('products.categories')->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        $this->authorize('edit categories');
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorize('edit categories');

        // Validation rules for category data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'code' => 'nullable',
            'parent_category_id' => 'nullable',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.categories', $category->id)->withErrors($validator)->withInput();
        }

        // Update the category
        $category->update($request->all());

        return redirect()->route('products.categories')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete categories');

        // Check if the category has any associated products
        if ($category->products()->exists()) {
            return redirect()->route('products.categories')->with('error', 'Cannot delete category. It has associated products.');
        }

        // If no associated products, proceed with deletion
        $category->delete();
        return redirect()->route('products.categories')->with('success', 'Category deleted successfully.');
    }

    
}
