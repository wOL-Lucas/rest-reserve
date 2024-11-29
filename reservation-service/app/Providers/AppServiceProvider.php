<?php

namespace App\Providers;

use App\Service\Interface\ReserveServiceInterface;
use App\Service\ReserveService;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ReserveServiceInterface::class, ReserveService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
