<?php

namespace App\Providers;

use App\Services\Auth\TokenFactory;
use App\Services\Auth\AuthService;
use App\Services\Contracts\Auth\AuthServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServiceRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AuthServiceInterface::class, function () {
            return new AuthService(new TokenFactory);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
