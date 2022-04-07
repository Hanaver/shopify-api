<?php

namespace Shopifyapi;

use Illuminate\Support\ServiceProvider;

class ShopifyApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('shopifyapi', function ($app){
            return new ShopifyApi($app['config']);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/shopifyapi.php' => config_path('shopifyapi.php')
        ]);
    }
}
