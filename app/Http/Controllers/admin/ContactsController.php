<?php

namespace App\Http\Controllers\admin;


use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Models\WebConfig;

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
            'google_track_code' => request('google_track_code'),
            'google_map' => request('google_map'),
            'contact_ok' => request('contact_ok'),
            'contact_ok_en' => request('contact_ok_en'),
        ]);

        return redirect('/admin/contacts/template');
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);

        return view('system.contact.show', compact('contact'));
    }


    public function destroy($id)
    {
        Contact::findOrFail($id)->delete();

        return redirect('/admin/contacts');
    }


    public function processed($id)
    {
        Contact::findOrFail($id)->update(['processed' => true]);

        return response()->json([
            'status' => 'success',
            'message' => 'An Contact is set to processed.']);
    }
}