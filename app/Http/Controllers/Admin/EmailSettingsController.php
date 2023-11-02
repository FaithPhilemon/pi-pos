<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Validator;

class EmailSettingsController extends Controller
{
    public function edit()
    {
        $this->authorize('edit email settings');
        $settings = EmailSetting::firstOrFail();
        return view('email_settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $this->authorize('edit email settings');

        // Validation rules for email settings
        $validator = Validator::make($request->all(), [
            'smtp_host' => 'nullable',
            'smtp_port' => 'nullable|integer',
            'smtp_username' => 'nullable',
            'smtp_password' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('email-settings.edit')->withErrors($validator)->withInput();
        }

        $settings = EmailSetting::firstOrFail();
        $settings->smtp_host = $request->input('smtp_host');
        $settings->smtp_port = $request->input('smtp_port');
        $settings->smtp_username = $request->input('smtp_username');
        $settings->smtp_password = $request->input('smtp_password');

        $settings->save();

        return redirect()->route('email-settings.edit')->with('success', 'Email settings updated successfully.');
    }
}

