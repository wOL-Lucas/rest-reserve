<?php

namespace App\Service\Interface;

interface QueuePublisherInterface
{
    public function publish($subject, $remitter, $message);
}