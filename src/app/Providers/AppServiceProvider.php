<?php

namespace App\Providers;

use App\Services\SiakadService;
use App\Services\RoomScanService;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Support\Facades\Gate;


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

        $this->app->singleton(RoomScanService::class, function ($app) {
            return new RoomScanService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->role == 'admin';
        });

        Gate::define('student', function (User $user) {
            return $user->role == 'student' || $user->role == 'class_rep';
        });

        Gate::define('class_rep', function (User $user) {
            return $user->role == 'class_rep';
        });


    }
}
