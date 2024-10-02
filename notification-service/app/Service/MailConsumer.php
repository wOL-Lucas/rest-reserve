<?php

namespace App\Service;

use App\Model\Sender;
use App\Service\Interface\MailConsumerInterface;
use Illuminate\Support\Facades\Mail;

class MailConsumer implements MailConsumerInterface {
    public function sendEmail($subject, $cc, $message)
    {
        $mailData = [
            'subject' => $subject,
            'cc' => $cc,
            'message' => $message
        ];

        Mail::to($cc)->send(new Sender($mailData));
    }
}