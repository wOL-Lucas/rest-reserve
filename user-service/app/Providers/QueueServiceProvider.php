<?php

namespace App\Providers;

use App\Service\Interface\QueueConsumerInterface;
use Illuminate\Support\ServiceProvider;
use App\Service\RabbitMQConsumer;

class QueueServiceProvider extends ServiceProvider
{
    private QueueConsumerInterface $queueConsumer;
    
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
        $this->queueConsumer = new RabbitMQConsumer();
    }

}
