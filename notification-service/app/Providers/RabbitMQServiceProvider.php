<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Service\RabbitMQConsumer;

class RabbitMQServiceProvider extends ServiceProvider
{
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
        $this->startRabbitMQConsumer();
    }

    protected function startRabbitMQConsumer()
    {
        $consumer = new RabbitMQConsumer();
        $consumer->consume();
    }
}
