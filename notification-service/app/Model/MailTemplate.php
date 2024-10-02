<?php

namespace App\Model;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;

use Illuminate\Queue\SerializesModels;

class MailTemplate extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $subject;
    public $fromAddress;
    public $fromName;

    public function __construct($message, $subject)
    {
        $this->message = $message;
        $this->subject = $subject;
        $this->fromAddress = env('MAIL_FROM_ADDRESS');
        $this->fromName = 'Rest Reserve';
    }

    public function build()
    {
        $mailData = [
            'message' => $this->message,
            'subject' => $this->subject,
        ];

        return $this->view('emails.template')
            ->from($this->fromAddress, $this->fromName)
            ->subject($this->subject)
            ->with('mailData', $mailData);
    }
}