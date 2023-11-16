<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Category;
use App\Models\Contact;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view products');
        $query = Product::query();
        $categories = Category::all();
        $stores = Store::all();
        $pageTitle = 'All Products';


        if ($request->has('type')) {
            $query->where('category_id', $request->input('type'));
            $pageTitle = Category::where('id', $request->input('type'))->first()->name;
        }

        // $products = $query->get();
        $products = $query->paginate(20); // 10 items per page,


        return view('products.index', compact('products', 'categories', 'stores', 'pageTitle'));
    }

    public function create()
    {
        $this->authorize('create products');
        $categories = Category::all();
        $contacts = Contact::all();
        $stores = Store::all();
        return view('products.create', compact('categories', 'contacts', 'stores'));
    }

    public function store(Request $request)
    {
        $this->authorize('create products');

        $validator = Validator::make($request->all(), [
            'name'              => 'required',
            'author'            => 'nullable',
            'ISBN'              => 'nullable',
            'description'       => 'nullable',
            'stock'             => 'nullable|integer',
            'alert_quantity'    => 'nullable|integer',
            'manage_stock'      => 'nullable|boolean',
            'price'             => 'numeric',
            'image'             => 'image|max:500', // Max 500KB image size
            'category_id'       => 'nullable|exists:categories,id',
            'subcategory_id'    => 'nullable|exists:categories,parent_category_id',
            'contact_id'        => 'nullable|exists:contacts,id',
            'store_id'          => 'nullable|exists:stores,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.index')->withErrors($validator)->withInput();
        }

        $product = new Product();

        $product->name              = $request->input('name');
        $product->author            = $request->input('author');
        $product->ISBN              = $request->input('ISBN');
        $product->description       = $request->input('description');
        $product->stock             = $request->input('stock');
        $product->alert_quantity    = $request->input('alert_quantity');
        $product->manage_stock      = $request->input('manage_stock', 0);
        $product->price             = $request->input('price');
        $product->category_id       = $request->input('category_id');
        $product->contact_id        = $request->input('contact_id');
        $product->store_id          = $request->input('store_id');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('product_images', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $this->authorize('edit products');
        $categories = Category::all();
        $contacts = Contact::all();
        $stores = Store::all();
        return view('products.edit', compact('product', 'categories', 'contacts', 'stores'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('edit products');

        $validator = Validator::make($request->all(), [
            'name'              => 'required',
            'author'            => 'nullable',
            'ISBN'              => 'nullable',
            'description'       => 'nullable',
            'stock'             => 'nullable|integer',
            'alert_quantity'    => 'nullable|integer',
            'manage_stock'      => 'nullable|boolean',
            'price'             => 'numeric',
            'image'             => 'image|max:500', // Max 500KB image size
            'category_id'       => 'nullable|exists:categories,id',
            'subcategory_id'    => 'nullable|exists:categories,parent_category_id',
            'contact_id'        => 'nullable|exists:contacts,id',
            'store_id'          => 'nullable|exists:stores,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.edit', $product->id)->withErrors($validator)->withInput();
        }

        $product->name              = $request->input('name');
        $product->author            = $request->input('author');
        $product->ISBN              = $request->input('ISBN');
        $product->description       = $request->input('description');
        $product->stock             = $request->input('stock');
        $product->alert_quantity    = $request->input('alert_quantity');
        $product->manage_stock      = $request->input('manage_stock', 0);
        $product->price             = $request->input('price');
        // $product->category_id    = $request->input('category_id');
        $product->category_id       = $request->input('subcategory_id');
        $product->contact_id        = auth()->user()->id;
        $product->store_id          = $request->input('store_id');

        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('public')->delete($product->image);

            $image = $request->file('image');
            $imagePath = $image->store('product_images', 'public');
            $product->image = $imagePath;
        }

        $product->save();

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }



    public function destroy(Product $product)
    {
        $this->authorize('delete products');

        try {
            // Check if the product has an image
            if ($product->image) {
                // Attempt to delete the image
                Storage::disk('public')->delete($product->image);
            }
        
            $product->delete();

            // Redirect with success message
            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            // Handle the exception
            return redirect()->route('products.index')->with('error', 'Error deleting product: ' . $e->getMessage());
        }

    }




    public function importCSV(Request $request)
    {
        $this->authorize('create products');

        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return redirect()->route('products.index')->withErrors($validator);
        }

        $file = $request->file('csv_file');
        $delimiter = ',';
        $header = null;
        $data = [];

        if (($handle = fopen($file, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        if (count($data) > 0) {
            foreach ($data as $row) {
                $product = new Product();
                $product->name = $row['name'];
                $product->description = $row['description'];
                $product->stock = $row['stock'];
                $product->alert_quantity = $row['alert_quantity'];
                $product->manage_stock = $row['manage_stock'] ?? 0;
                $product->price = $row['price'];
                $product->category_id = $row['category_id'];
                $product->contact_id = $row['contact_id'];
                $product->store_id = $row['store_id'];

                $product->save();
            }
            return redirect()->route('products.index')->with('success', 'Products imported successfully.');
        }

        return redirect()->route('products.index')->with('error', 'No valid data found in the CSV file.');
    }
}
