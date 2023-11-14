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

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view sales');
        $stores = Store::all();
        $paymentMethods = PaymentMethod::all();
        $saleStatuses = SaleStatus::all();
        $paymentStatuses = PaymentStatus::all();
        $shippingStatuses = ShippingStatus::all();
        $customers = Contact::where('contact_group', 1)->get();
        
        $pageTitle = 'All Sales';


        $query = Sale::query();

        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->input('payment_status'));
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
        $sales = $query->paginate(10); // 10 items per page,

        return view('sales.index', compact('sales',
                                           'pageTitle',
                                           'stores',
                                           'paymentMethods',
                                           'saleStatuses',
                                           'paymentStatuses',
                                           'shippingStatuses',
                                           'customers'
                                        ));
    }

    // public function create()
    // {
    //     $this->authorize('create sales');
    //     return view('sales.create');
    // }

    public function store(Request $request)
    {
        $this->authorize('create sales');

        // Validation rules for the sale data
        $validator = Validator::make($request->all(), [
            'invoice_number'    => 'nullable',
            'date'              => 'required|date',
            'phone_number'      => 'required',
            'customer_name'     => 'required',
            'store'             => 'required',
            'payment_status'    => 'required',
            'sale_status'       => 'required',
            'payment_method'    => 'required',
            'total_amount'      => 'numeric',
            'total_paid'        => 'numeric',
            'total_items'       => 'integer',
            'shipping_status'   => 'integer',
            'shipping_details'  => 'nullable',
            'added_by'          => 'exists:users,id',
            'staff_note'        => 'nullable',
            'sale_note'         => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('sales.index')->withErrors($validator)->withInput();
        }

        try {

            // Generate invoice number
            $lastSale = Sale::latest()->first();
            $lastId = $lastSale ? $lastSale->id : 0;
            $randomNumber = rand(1000, 9999); 
            $invoiceNumber = 'INV' . ($lastId + 1). $randomNumber;

            $sale = new Sale();

            $sale->invoice_number       = $invoiceNumber;
            $sale->date                 = $request->date;
            $sale->phone_number         = $request->phone_number;
            $sale->customer_name        = $request->customer_name;
            $sale->store                = $request->store;
            $sale->sale_status_id       = $request->sale_status;
            $sale->payment_status_id    = $request->payment_status;
            $sale->payment_method_id    = $request->payment_method;  
            $sale->total_amount         = $request->total_amount;
            $sale->total_paid           = $request->total_paid;
            $sale->total_items          = $request->total_items;
            $sale->shipping_status_id   = $request->shipping_status;
            $sale->shipping_details     = $request->shipping_details;
            $sale->added_by             = auth()->user()->id;
            $sale->staff_note           = $request->staff_note;
            $sale->sale_note            = $request->sale_note;

            $sale->save();

            return redirect()->route('sales.index')->with('success', 'Sale created successfully.');

        }catch (\Exception $e) {
            $bug = $e->getMessage();
            return redirect()->back()->with('error', $bug);
        }
    }

    public function edit(Sale $sale)
    {
        $this->authorize('edit sales');
        return view('sales.edit', compact('sale'));
    }

    public function update(Request $request, Sale $sale)
    {
        $this->authorize('edit sales');

        // Validation rules for the sale data
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'required',
            'date' => 'required|date',
            'customer_name' => 'required',
            'payment_status' => 'required',
            'payment_method' => 'required',
            'total_amount' => 'numeric',
            'total_paid' => 'numeric',
            'total_items' => 'integer',
            'shipping_status' => 'integer',
            'shipping_details' => 'nullable',
            'added_by' => 'exists:users,id',
            'staff_note' => 'nullable',
            'sale_note' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('sales.edit', $sale->id)->withErrors($validator)->withInput();
        }

        // Update the sale
        $sale->update($request->all());

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
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


