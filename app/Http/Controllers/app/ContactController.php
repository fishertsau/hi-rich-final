<?php

namespace App\Http\Controllers\app;

use App\Mail\UserContactEmail;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Models\WebConfig;
use Mail;

class ContactController extends Controller
{
    public function create()
    {
        return view('app.contact');
    }

    public function store()
    {
        
// TODO: Implement this
//        $validInput = request()->validate([
//            'title' => '',
//            'contact' => 'required',
//            'email' => 'required',
//            'tel' => 'required',
//            'address' => '',
//            'fax' => '',
//            'message' => 'required',
//        ]);
//
//        $contact = Contact::create($validInput);

//        $this->sendNotificationEmail($contact);

        return redirect('contact-ok');
    }

    public function contactOk()
    {
        return view('app.contact-ok');
    }

    /**
     * @param $inquiry
     */
    // TODO: Implement this
    private function sendNotificationEmail($contact)
    {
        Mail::to($this->getSiteMailReceivers())
            ->send(new UserContactEmail($contact));
    }

    private function getSiteMailReceivers()
    {
        return explode(',', WebConfig::firstOrCreate()->mail_receivers);
    }
}
