<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            [
                'layouts.default',
            ],
            'App\Http\Composers\Menu'
        );
        view()->composer(
            [
                'layouts.partials.javascript',
            ],
            'App\Http\Composers\Route'
        );
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
