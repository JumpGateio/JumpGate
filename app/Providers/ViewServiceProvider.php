<?php

namespace App\Providers;

use App\Services\JumpGate\ViewResolution\Builders\Inertia;
use App\Services\JumpGate\ViewResolution\Builders\View;
use App\Services\JumpGate\ViewResolution\Collectors\AutoViewCollector;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('viewResolver', function ($app) {
            return $app->make(View::class);
        });
        $this->app->singleton('inertiaResolver', function ($app) {
            return $app->make(Inertia::class);
        });

        if (checkDebugbar()) {
            $debugbar = $this->app['debugbar'];

            if ($debugbar->shouldCollect('auto_views')) {
                $debugbar->addCollector(new AutoViewCollector());
            }
        }
    }

    public function boot()
    {
        if ($this->app['config']->get('jumpgate.view-resolution.load_layout')) {
            $this->app['view']->addLocation(resource_path('views'));
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['viewResolver'];
    }
}
