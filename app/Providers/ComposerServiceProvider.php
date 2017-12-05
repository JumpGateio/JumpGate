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
            'App\Http\Composers\MenuComposer'
        );
        view()->composer(
            [
                'layouts.partials.javascript',
            ],
            'App\Http\Composers\RouteComposer'
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
