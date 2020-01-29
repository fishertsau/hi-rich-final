<?php

namespace App\Http\Controllers\admin;

use App\Models\Contact;
use App\Models\WebConfig;
use App\Http\Controllers\Controller;

class ContactsController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->paginate(10);
        return view('system.contact.index', compact('contacts'));
    }

    public function config()
    {
        return view('system.contact.config');
    }

    public function template()
    {
        return view('system.contact.template');
    }

    public function updateTemplate()
    {
        WebConfig::firstOrCreate()->update([
            'contact_ok' => request('contact_ok'),
        ]);

        return redirect('/admin/contacts/template');
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->update([
            'processed' => true
        ]);

        return view('system.contact.show', compact('contact'));
    }


    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();

        return redirect('/admin/contacts');
    }
}