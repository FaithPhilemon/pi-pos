<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Validator;

class StoresController extends Controller
{
    public function index()
    {
        $this->authorize('view stores');
        $stores = Store::all();
        return view('stores.index', compact('stores'));
    }

    public function create()
    {
        $this->authorize('create stores');
        return view('stores.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create stores');

        // Validation rules for store data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
            'state' => 'required',
            'address' => 'nullable',
            'phone_number' => 'nullable',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|max:500',
            'icon' => 'nullable|image|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->route('stores.create')->withErrors($validator)->withInput();
        }

        // Upload logo and icon
        $logoPath = $request->file('logo')->store('stores', 'public');
        $iconPath = $request->file('icon')->store('stores', 'public');

        // Create the store
        $store = new Store;
        $store->name = $request->input('name');
        $store->city = $request->input('city');
        $store->state = $request->input('state');
        $store->address = $request->input('address');
        $store->phone_number = $request->input('phone_number');
        $store->email = $request->input('email');
        $store->logo = $logoPath;
        $store->icon = $iconPath;
        $store->save();

        return redirect()->route('stores.index')->with('success', 'Store created successfully.');
    }

    public function edit(Store $store)
    {
        $this->authorize('edit stores');
        return view('stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $this->authorize('edit stores');

        // Validation rules for store data
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'city' => 'required',
            'state' => 'required',
            'address' => 'nullable',
            'phone_number' => 'nullable',
            'email' => 'nullable|email',
            'logo' => 'nullable|image|max:500',
            'icon' => 'nullable|image|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->route('stores.edit', $store->id)->withErrors($validator)->withInput();
        }

        // Update the store
        $store->name = $request->input('name');
        $store->city = $request->input('city');
        $store->state = $request->input('state');
        $store->address = $request->input('address');
        $store->phone_number = $request->input('phone_number');
        $store->email = $request->input('email');

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('stores', 'public');
            $store->logo = $logoPath;
        }

        if ($request->hasFile('icon')) {
            $iconPath = $request->file('icon')->store('stores', 'public');
            $store->icon = $iconPath;
        }

        $store->save();

        return redirect()->route('stores.index')->with('success', 'Store updated successfully.');
    }

    public function destroy(Store $store)
    {
        $this->authorize('delete stores');
        $store->delete();
        return redirect()->route('stores.index')->with('success', 'Store deleted successfully.');
    }
}
