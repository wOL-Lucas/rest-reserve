<?php

namespace App\Providers;

use App\Service\Interface\QueuePublisherInterface;
use App\Service\Interface\UserServiceInterface;
use App\Service\RabbitMQPublisher;
use App\Service\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(QueuePublisherInterface::class, RabbitMQPublisher::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
