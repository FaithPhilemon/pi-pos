<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Contact;
use App\Models\ContactGroup;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Str;

class ContactsController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->query('type');
        
        $pageTitle = match ($type) {
            'suppliers' => 'Suppliers',
            'customers' => 'Customers',
            default => 'All Contacts',
        };

        $contacts = Contact::when($type, function ($query) use ($type) {
            $group = ContactGroup::where('name', $type)->first();
            if ($group) {
                return $query->where('contact_group', $group->id);
            }
            return $query;
        })->paginate(10); 

        $groups = ContactGroup::all();

        return view('contacts.index', compact('contacts', 'pageTitle', 'groups'));
    }

    public function create()
    {
        $contactGroups = ContactGroup::all();
        return view('contacts.create', compact('contactGroups'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'nullable',
            'contact_name' => 'required',
            'contact_group' => 'required|exists:contact_groups,id',
            'email' => 'email|nullable',
            'phone_number' => 'nullable',
            'address' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contacts.index')->withErrors($validator)->withInput();
        }

        Contact::create([
            'business_name' => $request->input('business_name'),
            'contact_name' => $request->input('contact_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'contact_group' => $request->input('contact_group'),
            'assigned_to' => auth()->user()->id,
            'address' => $request->input('address'),
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    public function edit(Contact $contact)
    {
        $contactGroups = ContactGroup::all();
        return view('contacts.edit', compact('contact', 'contactGroups'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), [
            'business_name' => 'required',
            'contact_name' => 'required',
            'contact_group' => 'required|exists:contact_groups,id',
            'email' => 'email|nullable',
            'phone_number' => 'nullable',
            'address' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contacts.edit', $contact->id)->withErrors($validator)->withInput();
        }

        $contact->update([
            'business_name' => $request->input('business_name'),
            'contact_name' => $request->input('contact_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'contact_group' => $request->input('contact_group'),
            'address' => $request->input('address'),
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }

    public function importCSV(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csv_file' => 'required|file|mimes:csv,txt',
        ]);

        if ($validator->fails()) {
            return redirect()->route('contacts.index')->withErrors($validator);
        }

        $file = $request->file('csv_file');
        $delimiter = ',';
        $header = null;
        $data = [];

        if (($handle = fopen($file, 'r')) !== false) {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                if (!$header) {
                    $header = $row;
                } else {
                    $data[] = array_combine($header, $row);
                }
            }
            fclose($handle);
        }

        if (count($data) > 0) {
            foreach ($data as $row) {
                Contact::create([
                    'business_name' => $row['business_name'],
                    'contact_name' => $row['contact_name'],
                    'email' => $row['email'],
                    'phone_number' => $row['phone_number'],
                    'contact_group' => $row['contact_group'],
                    'assigned_to' => auth()->user()->id,
                    'address' => $row['address'],
                ]);
            }
            return redirect()->route('contacts.index')->with('success', 'Contacts imported successfully.');
        }

        return redirect()->route('contacts.index')->with('error', 'No valid data found in the CSV file.');
    }
}