<?php

namespace App\Providers;

use App\Service\Interface\QueuePublisherInterface;
use App\Service\RabbitMQPublisher;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    private QueuePublisherInterface $queuePublisher;

    public function register(): void
    {

    }

    public function boot(): void
    {
        $this->queuePublisher = new RabbitMQPublisher();
    }

}