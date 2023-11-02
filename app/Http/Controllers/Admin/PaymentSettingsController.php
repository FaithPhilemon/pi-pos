<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\Validator;

class PaymentSettingsController extends Controller
{
    public function edit()
    {
        $this->authorize('edit payment settings');
        $settings = PaymentSetting::firstOrFail();
        return view('payment_settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->authorize('edit payment settings');

        // Validation rules for payment settings
        $validator = Validator::make($request->all(), [
            'currency' => 'required',
            'currency_symbol' => 'required',
            'enable_payments' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->route('payment-settings.edit')->withErrors($validator)->withInput();
        }

        $settings = PaymentSetting::firstOrFail();
        $settings->currency = $request->input('currency');
        $settings->currency_symbol = $request->input('currency_symbol');
        $settings->enable_payments = $request->input('enable_payments', 0);

        $settings->save();

        return redirect()->route('payment-settings.edit')->with('success', 'Payment settings updated successfully.');
    }
}
