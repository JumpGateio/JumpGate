<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\File;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

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
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapRouteClasses();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Convert class route files into valid routes.
     */
    private function mapRouteClasses()
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
