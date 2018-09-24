<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use JumpGate\Core\Contracts\Routes;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    public $files;

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    public function __construct($app)
    {
        parent::__construct($app);

        $this->files = app('files');
    }

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->load();

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
     * Register all of the routes in the selected directories.
     */
    protected function load()
    {
        $paths  = supportCollector(config('route.paths'));
        $router = $this->app['router'];

        $paths
            ->flatMap(function ($path) use (&$routeDirectories) {
                return $this->files->glob($path);
            })
            ->flatMap(function ($path) {
                return $this->files->files($path);
            })
            ->filter()
            ->map(function ($file) {
                return $this->getClassFromFilePath($file);
            })
            ->filter()
            ->each(function ($provider) use ($router) {
                $this->convertProviderToRoutes($provider, $router);
            });
    }

    /**
     * Using a file path, determine the fully qualified class name.
     *
     * @param \SplFileInfo $file
     *
     * @return null|string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getClassFromFilePath(\SplFileInfo $file)
    {
        $contents = $this->files->get($file->getPathName());

        preg_match('/^namespace (.+);/m', $contents, $matches);
        $namespace = '\\' . last($matches) . '\\';

        preg_match('/^class (\w+)[\s\r\n\w]+/m', $contents, $matches);
        $class = $namespace . last($matches);

        $class = new $class;

        if ($class instanceof Routes) {
            return $class;
        }

        return null;
    }

    /**
     * Take a route class and add the routes to Laravel's router.
     *
     * @param \JumpGate\Core\Contracts\Routes $provider
     * @param \Illuminate\Routing\Router      $router
     */
    protected function convertProviderToRoutes(Routes $provider, Router $router)
    {
        $attributes = [
            'prefix'     => $provider->getPrefix(),
            'namespace'  => $provider->getNamespace(),
            'middleware' => $provider->getMiddleware(),
        ];

        if (! is_null($provider->getRole())) {
            $attributes['is'] = $provider->getRole();
        }

        if (! is_null($provider->getPermissions())) {
            $attributes['can'] = $provider->getPermissions();
        }

        $router->group($attributes, function ($router) use ($provider) {
            $provider->routes($router);
        });
    }
}
