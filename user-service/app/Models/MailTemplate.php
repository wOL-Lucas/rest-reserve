<?php

namespace App\Models;

class MailTemplate
{

    public String $subject;
    public String $remitter;
    public String $message;

    public function __construct($subject, $remitter, $message)
    {
        $this->subject = $subject;
        $this->remitter = $remitter;
        $this->message = $message;
    }

    public function jsonSerialize(): array
    {
        return [
            'subject' => $this->subject,
            'remitter' => $this->remitter,
            'message' => $this->message,
        ];
    }
}
