<?php

namespace App\Mail;

use App\Models\Inquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserInquiryEmail extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Inquiry
     */
    public $inquiry;

    /**
     * Create a new message instance.
     *
     * @param Inquiry $inquiry
     */
    public function __construct(Inquiry $inquiry)
    {
        $this->inquiry = $inquiry;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.userInquiry', [
            'inquiry' => $this->inquiry
        ])->subject('有人從網站送出詢問');
    }
}
