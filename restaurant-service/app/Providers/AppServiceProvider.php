<?php

namespace App\Providers;

use App\Service\AddressService;
use App\Service\Interface\AddressServiceInterface;
use App\Service\RestaurantService;
use App\Service\Interface\RestaurantServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RestaurantServiceInterface::class, RestaurantService::class);
        $this->app->bind(AddressServiceInterface::class, AddressService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
