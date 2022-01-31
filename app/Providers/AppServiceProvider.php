<?php

namespace App\Providers;

use App\Services\NYTApiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->singleton(\App\Services\Contracts\NYTApiService::class, function() {
            return new NYTApiService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [
            \App\Services\Contracts\NYTApiService::class,
        ];
    }
}
