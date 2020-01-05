<?php

namespace App\Http\Controllers\app;

use App\Mail\UserContactEmail;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\WebConfig;
use Mail;

class ContactController extends Controller
{
    public function create()
    {
        $sites = Site::published()
            ->orderByRanking()
            ->get();

        return view('app.contact', compact('sites'));
    }

    public function store()
    {

// TODO: Implement this
        $validInput = request()->validate([
            'contact' => 'required',
            'tel' => '',
            'email' => 'required',
            'message' => 'required'
        ]);


        // todo: change this
        $contact = Contact::create($validInput);

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
