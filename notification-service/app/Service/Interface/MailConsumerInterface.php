<?php

namespace App\Service\Interface;

interface MailConsumerInterface
{
    public function sendEmail($subject, $cc, $message);
}