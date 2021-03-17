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
        view()->composer(['layouts.default'], 'App\Http\Composers\Menu');
        view()->composer(['layouts.partials.sidebar-menu'], 'App\Http\Composers\AdminSidebar');
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
