<?php

namespace App\Models;

class MailTemplate 
{

    public $subject;
    public $remitter;
    public $message;

    public function __construct($subject, $remitter, $message)
    {
        $this->subject = $subject;
        $this->remitter = $remitter;
        $this->message = $message;
    }

    public function jsonSerialize()
    {
        return [
            'subject' => $this->subject,
            'remitter' => $this->remitter,
            'message' => $this->message,
        ];
    }
}