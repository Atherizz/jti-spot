<?php

namespace App\Providers;

use App\Http\Services\SiakadService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SiakadService::class, function ($app) {
            $siakadUrl = env('SIAKAD_URL', 'https://siakad.polinema.ac.id');
            return new SiakadService($siakadUrl);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
