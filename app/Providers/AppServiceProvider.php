<?php

namespace App\Providers;

use App\Abstracts\DataBuilderFactoryAbstract;
use App\Helpers\DataBuilderFactory;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DataBuilderFactoryAbstract::class, function (Application $app) {
            return new DataBuilderFactory();
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
