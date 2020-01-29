<?php

namespace App\Http\Controllers\app;

use Mail;
use App\Models\Site;
use App\Models\Contact;
use App\Models\WebConfig;
use App\Mail\UserContactEmail;
use App\Http\Controllers\Controller;

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
        $validInput = request()->validate([
            'title' => 'required',
            'contact' => 'required',
            'tel' => '',
            'email' => 'required',
            'message' => 'required'
        ]);


        $contact = Contact::create($validInput);
        $this->sendNotificationEmail($contact);

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
