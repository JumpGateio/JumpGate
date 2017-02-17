<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\File;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Route providers that contain the configuration of a route group.
     *
     * @var array
     */
    protected $providers = [
        \App\Http\Routes\Home::class,
    ];

    public function __construct($app)
    {
        parent::__construct($app);

        if (empty($this->providers)) {
            $this->getProvidersFromServicesConfig();
        }
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app['router'];

        foreach ($this->providers as $provider) {
            $provider = new $provider;

            $router->patterns($provider->patterns());
        }

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $router = $this->app['router'];

        foreach ($this->providers as $provider) {
            $provider = new $provider;

            $router->group([
                'prefix'     => $provider->prefix(),
                'namespace'  => $provider->namespacing(),
                'middleware' => $provider->middleware(),
            ], function ($router) use ($provider) {
                $provider->routes($router);
            });
        }
    }

    /**
     * Get an array of providers from the services.json.
     */
    private function getProvidersFromServicesConfig()
    {
        if (file_exists(base_path('bootstrap/services.json'))) {
            $services = collect(
                json_decode(
                    file_get_contents(base_path('bootstrap/services.json'))
                )
            );

            $this->providers = $services->flatMap(function ($service) {
                if (isset($service->routes)) {
                    return $service->routes;
                }
            })->toArray();
        }
    }
}
