<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;


use App\Models\Product;
use App\Models\Store;
use App\Models\Contact;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Category;


use Illuminate\Http\Request;


class PosController extends Controller
{
    public function index(Request $request)
    {
        $perPage = 50; // Number of products per page

        $query = Product::with('category')
            ->select('id', 'name', 'image', 'category_id', 'price');

        // Real-time search
        if ($request->has('searchTerm')) {
            $searchTerm = $request->input('searchTerm');
            $query->where('name', 'like', '%' . $searchTerm . '%');
        }

        // Real-time category filter
        if ($request->has('categoryId')) {
            $categoryId = $request->input('categoryId');
            $query->where('category_id', $categoryId);
        }

        $products   = $query->paginate($perPage);
        $customers  = Contact::where('contact_group', 1)->get();
        $stores     = Store::all();
        $categories = Category::where('parent_category_id', null)->get();;

        if ($request->ajax()) {
            return view('sales.products', compact('products', 'customers', 'stores', 'categories'));
        }

        return view('sales.pos', compact('products', 'customers', 'stores', 'categories'));
    }

    // public function index()
    // {
    //     $perPage = 20; // Number of products per page

    //     $products = Product::with('category')
    //         ->select('id', 'name', 'image', 'category_id', 'price')
    //         ->paginate($perPage);

    //     $customers = Contact::where('contact_group', 1)->get();
    //     $stores = Store::all();

    //     return view('sales.pos', compact('products', 'customers', 'stores'));
    // }


    public function store(Request $request)
    {
        // exit("We got here");
        $this->authorize('create sales');

        // Validation rules for the sale data
        $validator = Validator::make($request->all(), [
            'invoice_number'    => 'nullable',
            'date'              => 'required|date',
            'phone_number'      => 'nullable',
            'customer_name'     => 'required',
            'store'             => 'required',
            'payment_status'    => 'nullable',
            'sale_status'       => 'nullable',
            'payment_method'    => 'nullable',
            'total_amount'      => 'numeric|nullable',
            'total_paid'        => 'numeric|nullable',
            'total_items'       => 'integer|nullable',
            'discount'          => 'integer|nullable',
            'shipping_status'   => 'integer',
            'shipping_details'  => 'nullable',
            'added_by'          => 'exists:users,id',
            'staff_note'        => 'nullable',
            'sale_note'         => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {


             // Generate invoice number
             $lastSale = Sale::latest()->first();
             $lastId = $lastSale ? $lastSale->id : 0;
             $randomNumber = rand(1000, 9999); 
             $invoiceNumber = ($lastId + 1). $randomNumber;


             $sale = Sale::create([
                'invoice_number'        => $invoiceNumber,
                'date'                  => $request->date,
                'phone_number'          => $request->phone_number,
                'customer_name'         => $request->customer_name,
                'store'                 => $request->store,
                'sale_status_id'        => 3, //$request->sale_status,
                'payment_status_id'     => 2, //$request->payment_status,
                'payment_method_id'     => 1, //$request->payment_method,
                'total_amount'          => 0, //$request->total_amount,
                'total_paid'            => 0, //$request->total_paid,
                'discount'              => $request->discount,
                'total_items'           => 0, //$request->total_items,
                'shipping_status_id'    => $request->shipping_status,
                'shipping_details'      => $request->shipping_details,
                'added_by'              => auth()->user()->id,
                'staff_note'            => $request->staff_note,
                'sale_note'             => $request->sale_note,
            ]);
            
            // Access the last inserted ID directly from the model
            $lastId = $sale->id;
            
            
            // Insert sale items
            foreach ($request->input('products') as $product) {
                SaleItem::create([
                    'sale_id'       => $lastId, // Use the last inserted ID
                    'product_name'  => $product['product_name'],
                    'price'         => $product['price'],
                    'quantity'      => $product['quantity'],
                    'total'         => $product['quantity'] * $product['price'],
                ]);
            }

            // Update totals in the sales table
            $sale->updateSaleTotals();

            return redirect()->back()->with('success', 'Sale created successfully.');
 
            
        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }
}
