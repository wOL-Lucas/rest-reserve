<?php

namespace App\Service;

use App\Model\MailTemplate;
use App\Service\Interface\MailConsumerInterface;
use Illuminate\Support\Facades\Mail;

class MailConsumer implements MailConsumerInterface {
    public function sendEmail($subject, $remitter, $message)
    {   
        echo "Sending email to: " . $remitter . "\n";
        Mail::to($remitter)->send(new MailTemplate($message, $subject));
    }
}