<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Managers\Movie;

class MovieManagerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MovieManager::class, function($app) {
            return new DashboardManager();
        });

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        return [MovieManager::class];
    }
}
