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
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('categories.create')->withErrors($validator)->withInput();
        }

        // Create the category
        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
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
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('categories.index', $category->id)->withErrors($validator)->withInput();
        }

        // Update the category
        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete categories');
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    
}
