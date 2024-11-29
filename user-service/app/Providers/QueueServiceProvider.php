<?php

namespace App\Providers;

use App\Service\Interface\QueuePublisherInterface;
use Illuminate\Support\ServiceProvider;
use App\Service\RabbitMQPublisher;

class QueueServiceProvider extends ServiceProvider
{
    private QueuePublisherInterface $queuePublisher;
    
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->queuePublisher = new RabbitMQPublisher();
    }

}
