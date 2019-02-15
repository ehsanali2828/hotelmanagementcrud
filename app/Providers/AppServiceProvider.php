<?php

namespace App\Providers;

use App\Repositories\AmenityRepository;
use App\Repositories\HotelRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\ImageRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Interfaces\HotelRepositoryInterface', function ($app) {
            return new HotelRepository();
        });

        $this->app->bind('App\Interfaces\AmenityRepositoryInterface', function ($app) {
            return new AmenityRepository();
        });

        $this->app->bind('App\Interfaces\ImageRepositoryInterface', function ($app) {
            return new ImageRepository();
        });

    }
}
