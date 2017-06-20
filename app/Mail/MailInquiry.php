<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class MailInquiry extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $MailInquiry;
    private $subject_type;
    public function __construct($mailDetails)
    {
        $this->MailInquiry  = $mailDetails['MailInquiry'];
        $this->subject_type      = $mailDetails['subject'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject($this->subject_type)->markdown('emails.client.inquiry', ['MailInquiry' => $this->MailInquiry]);
    }
}
