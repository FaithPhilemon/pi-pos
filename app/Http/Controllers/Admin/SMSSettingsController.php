<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SMSSetting;
use Illuminate\Support\Facades\Validator;

class SMSSettingsController extends Controller
{
    public function edit()
    {
        $this->authorize('edit sms settings');
        $settings = SMSSetting::firstOrFail();
        return view('sms_settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->authorize('edit sms settings');

        // Validation rules for SMS settings
        $validator = Validator::make($request->all(), [
            'twilio_from' => 'required',
            'twilio_sid' => 'nullable',
            'twilio_token' => 'nullable',
            'api_key' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('sms-settings.edit')->withErrors($validator)->withInput();
        }

        $settings = SMSSetting::firstOrFail();
        $settings->twilio_from = $request->input('twilio_from');
        $settings->twilio_sid = $request->input('twilio_sid');
        $settings->twilio_token = $request->input('twilio_token');
        $settings->api_key = $request->input('api_key');

        $settings->save();

        return redirect()->route('sms-settings.edit')->with('success', 'SMS settings updated successfully.');
    }
}

