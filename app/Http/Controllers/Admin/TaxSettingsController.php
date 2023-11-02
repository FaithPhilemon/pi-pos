<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaxSetting;
use Illuminate\Support\Facades\Validator;

class TaxSettingsController extends Controller
{
    public function edit()
    {
        $this->authorize('edit tax settings');
        $settings = TaxSetting::firstOrFail();
        return view('tax_settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->authorize('edit tax settings');

        // Validation rules for tax settings
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'rate' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->route('tax-settings.edit')->withErrors($validator)->withInput();
        }

        $settings = TaxSetting::firstOrFail();
        $settings->name = $request->input('name');
        $settings->rate = $request->input('rate');

        $settings->save();

        return redirect()->route('tax-settings.edit')->with('success', 'Tax settings updated successfully.');
    }
}

