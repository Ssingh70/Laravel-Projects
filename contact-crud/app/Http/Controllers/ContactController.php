<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    # show the contact list
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    #add new contact form 
    public function create()
    {
        return view('contacts.create');
    }

    #store new contact form
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
        ]);

        Contact::create($request->all());
        return redirect()->route('contacts.index')->with('success', 'Contact created successfully.');
    }

    # show the edit form
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    #update the contact details
    public function update(Request $request, Contact $contact)
    {
        $validator = $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:contacts,email,' . $contact->id,
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
        ]);

        $contact->update($request->all());
        return redirect()->route('contacts.index')->with('success', 'Contact updated successfully.');
    }

    #delete the contact details
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index')->with('success', 'Contact deleted successfully.');
    }

    #bulk import the contact details from xml file
    public function import(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|mimes:xml',
        ]);

        // Load the XML file
        $xml = simplexml_load_file($request->file('xml_file'));

        foreach ($xml->contact as $contactData) {
            // Validate the phone number using regex (same rule as before)
            $phone = (string) $contactData->phone;
            if (!preg_match('/^\+?[0-9]*$/', $phone)) {
                return redirect()->route('contacts.index')->with('error', 'Invalid phone number format in the XML file.');
            }

            // Create the contact if the phone number is valid
            Contact::create([
                'first_name' => (string) $contactData->first_name,
                'last_name' => (string) $contactData->last_name,
                'email' => (string) $contactData->email,
                'phone' => $phone,
            ]);
        }

        return redirect()->route('contacts.index')->with('success', 'Contacts imported successfully.');
    }

}
