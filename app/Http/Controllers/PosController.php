<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;



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
        $perPage = 30; // Number of products per page

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

    public function store(Request $request)
    {
        // Validation rules for the sale data
        $validator = Validator::make($request->all(), [
            'invoice_number'    => 'nullable',
            'date'              => 'nullable|date',
            'phone_number'      => 'nullable',
            'customer_name'     => 'required',
            'store'             => 'required',
            'payment_status'    => 'nullable',
            'sale_status'       => 'nullable',
            'payment_method'    => 'nullable',
            'total_amount'      => 'numeric|nullable',
            'total_paid'        => 'numeric|nullable',
            'total_items'       => 'integer|nullable',
            'discount'          => 'nullable|integer',
            'shipping_status'   => 'integer',
            'shipping_details'  => 'nullable',
            'added_by'          => 'exists:users,id',
            'staff_note'        => 'nullable',
            'sale_note'         => 'nullable',
            'hold_reference'    => 'nullable|string|max:255', // Validation rule for hold reference
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Determine the sale status based on whether a hold reference is provided
            $sale_status = $request->filled('hold_reference') ? 5 : 3;

            // Generate invoice number
            $lastSale = Sale::latest()->first();
            $lastId = $lastSale ? $lastSale->id : 0;
            $randomNumber = rand(1000, 9999); 
            $invoiceNumber = ($lastId + 1). $randomNumber;

            // Prepare sale data
            $saleData = [
                'invoice_number'        => $invoiceNumber,
                'date'                  => date('Y-m-d H:i:s'),
                'phone_number'          => $request->phone_number,
                'customer_name'         => $request->customer_name,
                'store'                 => $request->store,
                'sale_status_id'        => $sale_status,
                'payment_status_id'     => $request->payment_status ?? 2,
                'payment_method_id'     => $request->payment_method ?? 1,
                'total_amount'          => $request->total_amount ?? 0,
                'total_paid'            => $request->total_paid ?? 0,
                'discount'              => $request->discount ?? 0,
                'total_items'           => $request->total_items ?? 0,
                'shipping_status_id'    => $request->shipping_status,
                'shipping_details'      => $request->shipping_details,
                'added_by'              => auth()->user()->id,
                'staff_note'            => $request->staff_note,
                'sale_note'             => $request->sale_note,
            ];

            // Check if a hold reference is provided
            if ($request->filled('hold_reference')) {
                // Find and delete any existing sale record with the same hold reference
                Sale::where('hold_reference', $request->hold_reference)->delete();
                // Create a new sale record with the provided hold reference
                $sale = Sale::create(array_merge($saleData, ['hold_reference' => $request->hold_reference]));
            } else {
                // Create a new sale record without a hold reference
                $sale = Sale::create($saleData);
            }


            // Access the last inserted ID directly from the model
            $lastId = $sale->id;
            
            
            // Insert sale items
            foreach ($request->input('products') as $product) {
                SaleItem::create([
                    'sale_id'       => $lastId, // Use the last inserted ID
                    'product_name'  => $product['product_name'],
                    'price'         => $product['price'],
                    'discount'      => $product['discount'],
                    'quantity'      => $product['quantity'],
                    // 'total'         => ($product['price'] * $product['quantity']) - $product['discount'],
                    'total'         => $product['price'] * $product['quantity'],
                ]);
            }

            // Update totals in the sales table
            $sale->updateSaleTotals();

            // return redirect()->route('sales.pos')->with('success', 'Sale created successfully.');

            if ($request->expectsJson()) {
                // Return a JSON response with success message and URL to reload
                return response()->json([
                    'success' => true,
                    'message' => 'Sale hold successfully.',
                    'reload_url' => route('sales.pos')
                ]);
            } else {
                // For regular form submission, redirect with success message
                return redirect()->route('sales.pos')->with('success', 'Sale created successfully.');
            }
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    
    // public function store(Request $request)
    // {
    //     // exit("We got here");
    //     // $this->authorize('create sales');

    //     // Validation rules for the sale data
    //     $validator = Validator::make($request->all(), [
    //         'invoice_number'    => 'nullable',
    //         'date'              => 'nullable|date',
    //         'phone_number'      => 'nullable',
    //         'customer_name'     => 'required',
    //         'store'             => 'required',
    //         'payment_status'    => 'nullable',
    //         'sale_status'       => 'nullable',
    //         'payment_method'    => 'nullable',
    //         'total_amount'      => 'numeric|nullable',
    //         'total_paid'        => 'numeric|nullable',
    //         'total_items'       => 'integer|nullable',
    //         'discount'          => 'nullable|integer',
    //         'shipping_status'   => 'integer',
    //         'shipping_details'  => 'nullable',
    //         'added_by'          => 'exists:users,id',
    //         'staff_note'        => 'nullable',
    //         'sale_note'         => 'nullable',
    //         'hold_reference'    => 'nullable|string|max:255', // Validation rule for hold reference
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()->withErrors($validator)->withInput();
    //     }

    //     try {

    //         $sale_status = 3;

    //         // Check if a hold reference is provided
    //         if ($request->filled('hold_reference')) {

    //             // Find if there's an existing record with the same hold reference
    //             $existingSale = Sale::where('hold_reference', $request->hold_reference)->first();

    //             // If an existing record is found, replace it
    //             if ($existingSale) {
    //                 $existingSale->delete(); // Delete the existing record
    //             }

    //             $sale_status = 5; // Set status to "HOLD"
    //         }


    //          // Generate invoice number
    //          $lastSale = Sale::latest()->first();
    //          $lastId = $lastSale ? $lastSale->id : 0;
    //          $randomNumber = rand(1000, 9999); 
    //          $invoiceNumber = ($lastId + 1). $randomNumber;

    //         // Log::info($request->all());

    //         $sale = Sale::updateOrCreate(
    //             ['hold_reference' => $request->hold_reference], // Check if hold reference already exists
    //             [
    //                 'invoice_number'        => $invoiceNumber,
    //                 'date'                  => date('Y-m-d H:i:s'), // Automatically set to current date and time
    //                 'phone_number'          => $request->phone_number,
    //                 'customer_name'         => $request->customer_name,
    //                 'store'                 => $request->store,
    //                 'sale_status_id'        => $sale_status, //$request->sale_status,
    //                 'payment_status_id'     => 2, //$request->payment_status,
    //                 'payment_method_id'     => 1, //$request->payment_method,
    //                 'total_amount'          => 0, //$request->total_amount,
    //                 'total_paid'            => 0, //$request->total_paid,
    //                 'discount'              => ($request->discount == "") ? 0 : $request->discount,
    //                 'total_items'           => 0, //$request->total_items,
    //                 'shipping_status_id'    => $request->shipping_status,
    //                 'shipping_details'      => $request->shipping_details,
    //                 'added_by'              => auth()->user()->id,
    //                 'staff_note'            => $request->staff_note,
    //                 'sale_note'             => $request->sale_note,
    //             ]
    //         );

    //         // Access the last inserted ID directly from the model
    //         $lastId = $sale->id;
            
            
    //         // Insert sale items
    //         foreach ($request->input('products') as $product) {
    //             SaleItem::create([
    //                 'sale_id'       => $lastId, // Use the last inserted ID
    //                 'product_name'  => $product['product_name'],
    //                 'price'         => $product['price'],
    //                 'quantity'      => $product['quantity'],
    //                 'total'         => $product['quantity'] * $product['price'],
    //             ]);
    //         }

    //         // Update totals in the sales table
    //         $sale->updateSaleTotals();
    //         // return redirect()->route('sales.pos')->with('success', 'Sale created successfully.');
            
    //         if ($request->expectsJson()) {
    //             return redirect()->route('sales.pos')->with('success', 'Hold successfully.'); // For regular form submission
    //             // return response()->json(['message' => 'Sale created successfully.'], 200); // For AJAX request
    //         } else {
    //             return redirect()->route('sales.pos')->with('success', 'Sale created successfully.'); // For regular form submission
    //         }
 
            
    //     }catch (\Exception $e) {
    //         // $bug = $e->getMessage();
    //         // return redirect()->back()->with('error', $bug);

    //         if ($request->expectsJson()) {
    //             return response()->json(['message' => 'Failed to create sale.'], 500); // For AJAX request
    //         } else {
    //             $bug = $e->getMessage(); 
    //             return redirect()->back()->with('error', $bug); // For regular form submission
    //         }
    //     }
    // }
}
