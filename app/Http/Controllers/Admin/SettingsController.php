<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    public function edit()
    {
        $this->authorize('edit application settings');
        $settings = Setting::firstOrFail();
        return view('settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->authorize('edit application settings');

        // Validation rules for application settings
        $validator = Validator::make($request->all(), [
            'invoice_prefix' => 'required',
            'supplier_prefix' => 'required',
            'customer_prefix' => 'required',
            'sale_prefix' => 'required',
            'purchase_prefix' => 'required',
            'currency' => 'required',
            'currency_symbol' => 'required',
            'enable_payments' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('settings.edit')->withErrors($validator)->withInput();
        }

        $settings = Setting::firstOrFail();
        $settings->invoice_prefix = $request->input('invoice_prefix');
        $settings->supplier_prefix = $request->input('supplier_prefix');
        $settings->customer_prefix = $request->input('customer_prefix');
        $settings->sale_prefix = $request->input('sale_prefix');
        $settings->purchase_prefix = $request->input('purchase_prefix');
        $settings->currency = $request->input('currency');
        $settings->currency_symbol = $request->input('currency_symbol');
        $settings->enable_payments = $request->input('enable_payments', 0);

        $settings->save();

        return redirect()->route('settings.edit')->with('success', 'Application settings updated successfully.');
    }
}
