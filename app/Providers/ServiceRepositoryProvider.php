<?php

namespace App\Providers;

use App\Services\Article\ArticleService;
use App\Services\Article\ArticleRepository;
use App\Services\Auth\TokenFactory;
use App\Services\Auth\AuthService;
use App\Services\Comment\CommentRepository;
use App\Services\Comment\CommentService;
use App\Services\Contracts\Article\ArticleServiceInterface;
use App\Services\Contracts\Auth\AuthServiceInterface;
use App\Services\Contracts\Comment\CommentServiceInterface;
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
        $this->app->instance("path.services", app_path('Services'));

        $this->app->singleton(AuthServiceInterface::class, function () {
            return new AuthService(new TokenFactory);
        });

        $this->app->singleton(ArticleServiceInterface::class, function () {
            return new ArticleService(new ArticleRepository);
        });

        $this->app->singleton(CommentServiceInterface::class, function () {
            return new CommentService(new CommentRepository);
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
