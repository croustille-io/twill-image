<?php

namespace Croustille\Image;

use Illuminate\Support\ServiceProvider;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('twill.image', function ($app) {
            return $app->make('Croustille\Image\ImageController');
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/images.php', 'images');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'image');
        $this->publishes([
            __DIR__.'/../config/images.php' => config_path('images.php'),
        ], 'config');
        $this->publishes(
            [__DIR__.'/../resources/js' => resource_path('js/vendor/croustille/twill-image')],
            'js'
        );
    }
}
