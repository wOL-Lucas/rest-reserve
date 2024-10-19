<?php

namespace App\Providers;

use App\Service\Interface\MailConsumerInterface;
use App\Service\Interface\QueueConsumerInterface;
use App\Service\MailConsumer;
use Illuminate\Support\ServiceProvider;
use App\Service\RabbitMQConsumer;

class QueueServiceProvider extends ServiceProvider
{

    private MailConsumerInterface $mailConsumer;
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
        sleep(10);

        $this->mailConsumer = new MailConsumer();
        $this->queueConsumer = new RabbitMQConsumer($this->mailConsumer);
        $this->startQueueConsumer();
    }

    protected function startQueueConsumer()
    {
        $this->queueConsumer->consume();
    }
}
