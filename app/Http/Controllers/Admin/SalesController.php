<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\User;
use App\Models\Store;
use App\Models\PaymentStatus;
use App\Models\SaleStatus;
use App\Models\PaymentMethod;
use App\Models\ShippingStatus;
use App\Models\Contact;
use App\Models\SaleItem;
use App\Models\Product;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view sales');
        $stores             = Store::all();
        $paymentMethods     = PaymentMethod::all();
        $saleStatuses       = SaleStatus::all();
        $paymentStatuses    = PaymentStatus::all();
        $shippingStatuses   = ShippingStatus::all();
        $users              = User::all();
        $customers          = Contact::where('contact_group', 1)->get();
        $products           = Product::select('id', 'name', 'price', 'author', 'ISBN')->get();



        $pageTitle = 'All Sales';


        $query = Sale::query();

        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
        }

        if ($request->has('type') && $request->has('type') == 'return') {
            $query->where('payment_status_id', 4);
        }

        if ($request->has('payment_method')) {
            $query->where('payment_method', $request->input('payment_method'));
        }

        if ($request->has('added_by')) {
            $user = User::find($request->input('added_by'));
            $query->where('added_by', $user->id);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('date', [$request->input('start_date'), $request->input('end_date')]);
        }

        // $sales = $query->get();
        $sales = $query->paginate(20); // 10 items per page,

        return view('sales.index', compact('sales',
                                           'pageTitle',
                                           'stores',
                                           'paymentMethods',
                                           'saleStatuses',
                                           'paymentStatuses',
                                           'shippingStatuses',
                                           'customers',
                                           'users',
                                           'products',
                                        ));
    }

    public function create()
    {
        $this->authorize('create sales');
        
        $customers          = Contact::where('contact_group', 1)->get();
        $stores             = Store::all();
        $paymentMethods     = PaymentMethod::all();
        $saleStatuses       = SaleStatus::all();
        $paymentStatuses    = PaymentStatus::all();
        $shippingStatuses   = ShippingStatus::all();
        $users              = User::all();
        $products           = Product::select('id', 'name', 'price', 'author', 'ISBN')->get();

        return view('sales.create', compact('customers',
                                            'stores',
                                            'shippingStatuses',
                                            'paymentMethods',
                                            'saleStatuses',
                                            'paymentStatuses',
                                            'shippingStatuses',
                                            'users',
                                            'products'
                                        ));
    }

    public function store(Request $request)
    {
        $this->authorize('create sales');

        // Validation rules for the sale data
        $validator = Validator::make($request->all(), [
            'invoice_number'    => 'nullable',
            'date'              => 'required|date',
            'phone_number'      => 'nullable',
            'customer_name'     => 'required',
            'store'             => 'required',
            'payment_status'    => 'required',
            'sale_status'       => 'required',
            'payment_method'    => 'required',
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
            return redirect()->route('sales.create')->withErrors($validator)->withInput();
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
                'sale_status_id'        => $request->sale_status,
                'payment_status_id'     => $request->payment_status,
                'payment_method_id'     => $request->payment_method,
                'total_amount'          => 0, //$request->total_amount,
                'total_paid'            => 0, //$request->total_paid,
                'discount'              => ($request->discount == "") ? 0 : $request->discount,
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

            return redirect()->route('sales.create')->with('success', 'Sale created successfully.');
 
            //  $sale = new Sale();
 
            //  $sale->invoice_number       = $invoiceNumber;
            //  $sale->date                 = $request->date;
            //  $sale->phone_number         = $request->phone_number;
            //  $sale->customer_name        = $request->customer_name;
            //  $sale->store                = $request->store;
            //  $sale->sale_status_id       = $request->sale_status;
            //  $sale->payment_status_id    = $request->payment_status;
            //  $sale->payment_method_id    = $request->payment_method;  
            //  $sale->total_amount         = $request->total_amount;
            //  $sale->total_paid           = $request->total_paid;
            //  $sale->total_items          = $request->total_items;
            //  $sale->shipping_status_id   = $request->shipping_status;
            //  $sale->shipping_details     = $request->shipping_details;
            //  $sale->added_by             = auth()->user()->id;
            //  $sale->staff_note           = $request->staff_note;
            //  $sale->sale_note            = $request->sale_note;
 
            //  $sale->save();


        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit(Sale $sale)
    {
        $this->authorize('edit sales');
        
        $products   = Product::select('id', 'name', 'price', 'author', 'ISBN')->get();
        $sale       = Sale::find($sale->id);
        $stores     = Store::all();
        $customers          = Contact::where('contact_group', 1)->get();
        $paymentMethods     = PaymentMethod::all();
        $saleStatuses       = SaleStatus::all();
        $paymentStatuses    = PaymentStatus::all();
        $shippingStatuses   = ShippingStatus::all();
        $saleItems           = SaleItem::where('sale_id', $sale->id)->get();


        // $customers  = Customer::all();

        return view('sales.edit', compact('sale',
                                          'products',
                                          'stores',
                                          'customers',
                                          'paymentMethods',
                                          'saleStatuses',
                                          'paymentStatuses',
                                          'shippingStatuses',
                                          'saleItems'
                                        ));
    }

    public function update(Request $request, Sale $sale)
    {
        $this->authorize('edit sales');

        // Validation rules for the sale data
        $validator = Validator::make($request->all(), [
            'invoice_number'    => 'nullable',
            'date'              => 'required|date',
            'phone_number'      => 'nullable',
            'customer_name'     => 'required',
            'store'             => 'required',
            'payment_status'    => 'required',
            'sale_status'       => 'required',
            'payment_method'    => 'required',
            'total_amount'      => 'numeric|nullable',
            'total_paid'        => 'numeric|nullable',
            'discount'          => 'integer|nullable',
            'total_items'       => 'integer|nullable',
            'shipping_status'   => 'integer',
            'shipping_details'  => 'nullable',
            'added_by'          => 'exists:users,id',
            'staff_note'        => 'nullable',
            'sale_note'         => 'nullable',
        ]);


        if ($validator->fails()) {
            return redirect()->route('sales.index', $sale->id)->withErrors($validator)->withInput();
        }
        
        
        try {
            
            $sale->date                 = $request->date;
            $sale->phone_number         = $request->phone_number;
            $sale->customer_name        = $request->customer_name;
            $sale->store                = $request->store;
            $sale->sale_status_id       = $request->sale_status;
            $sale->payment_status_id    = $request->payment_status;
            $sale->payment_method_id    = $request->payment_method;  
            $sale->discount             = ($request->discount == "") ? 0 : $request->discount;
            
            // $sale->invoice_number       = $request->invoice_number;
            // $sale->total_amount         = $request->total_amount;
            // $sale->total_paid           = $request->total_paid;
            // $sale->total_items          = $request->total_items;
            // $sale->shipping_status_id   = $request->shipping_status;
            // $sale->shipping_details     = $request->shipping_details;
            // $sale->added_by             = $request->added_by;
            // $sale->staff_note           = $request->staff_note;
            // $sale->sale_note            = $request->sale_note;

            $sale->save();
            
            // update sale items
            $saleItems          = SaleItem::where('sale_id', $sale->id)->get();
            $updatedSaleItems   = [];

            if(count($request->input('products')) > 0){
                foreach ($request->input('products') as $product) {
                    // exit(print_r($request->input('products')));


                    SaleItem::updateOrCreate(
                        ['product_name' => $product['product_name'] ],
                        [
                            'sale_id'       => $product['sale_id'],
                            'product_name'  => $product['product_name'],
                            'price'         => $product['price'],
                            'quantity'      => $product['quantity'],
                            'total'         => $product['quantity'] * $product['price']
                        ]
                    );
                    
                    $updatedSaleItems[] = $product['id'];

                }
            }


            // deleted removed products from the cards
            foreach($saleItems as $saleItem){
                if(!in_array($saleItem['id'], $updatedSaleItems)){
                    SaleItem::destroy($saleItem['id']);
                }
            }

            // Update totals in the sales table
            $sale->updateSaleTotals();
            

            return redirect()->back()->with('success', 'Sale updated successfully.');

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function destroy(Sale $sale)
    {
        $this->authorize('delete sales');
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }

    // public function import(Request $request)
    // {
    //     $this->authorize('create sales');

    //     $validator = Validator::make($request->all(), [
    //         'file' => 'required|file|mimes:csv,xls,xlsx',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->route('sales.index')->withErrors($validator);
    //     }

    //     $file = $request->file('file');

    //     Excel::import(new SaleImport, $file);

    //     return redirect()->route('sales.index')->with('success', 'Sales imported successfully.');
    // }
}


