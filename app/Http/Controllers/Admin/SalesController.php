<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Sale;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('view sales');

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

        $sales = $query->get();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $this->authorize('create sales');
        return view('sales.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create sales');

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
            return redirect()->route('sales.create')->withErrors($validator)->withInput();
        }

        // Create the sale
        Sale::create($request->all());

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
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


