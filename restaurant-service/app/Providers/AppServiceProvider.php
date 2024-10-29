<?php

namespace App\Providers;

use App\Service\AddressService;
use App\Service\Interface\AddressServiceInterface;
use App\Service\Interface\MenuServiceInterface;
use App\Service\RestaurantService;
use App\Service\Interface\RestaurantServiceInterface;
use App\Service\Interface\ReviewServiceInterface;
use App\Service\MenuService;
use App\Service\ReviewService;
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
        $this->app->bind(ReviewServiceInterface::class, ReviewService::class);
        $this->app->bind(MenuServiceInterface::class, MenuService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
