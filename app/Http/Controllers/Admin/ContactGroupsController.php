<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactGroup;

class ContactGroupsController extends Controller
{
    public function index()
    {
        $groups = ContactGroup::all();
        return view('contacts.groups', compact('groups'));
    }

    public function create()
    {
        return view('contact_groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        ContactGroup::create([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('contacts.groups')->with('success', 'Contact group created successfully.');
    }

    public function edit(ContactGroup $contactGroup)
    {
        return view('contact_groups.edit', compact('contactGroup'));
    }

    public function update(Request $request, ContactGroup $contactGroup)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $contactGroup->update([
            'name' => $request->input('name'),
        ]);

        return redirect()->route('contacts.groups')->with('success', 'Contact group updated successfully.');
    }

    public function destroy(ContactGroup $contactGroup)
    {
        $contactGroup->delete();
        return redirect()->route('contact-groups.index')->with('success', 'Contact group deleted successfully.');
    }
}
