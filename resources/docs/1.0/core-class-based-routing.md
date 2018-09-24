# Class Based Routing

---

- [Introduction](#introduction)
- [RouteServiceProvider](#service-provider)
- [Usage](#usage)

<a name="introduction"></a>
## Introduction

Class based routing is an idea to use proper PHP classes for route groups.  Each class used in this way behaves like a route 
group.  This is an alternative to using laravel's default route files.  You are always welcome to continue using those though.

<a name="service-provider"></a>
## RouteServiceProvider

You will first need to make sure your `RouteServiceProvider` can understand these classes.  In `jumpgate/jumpgate` this is 
done for you.  To set it up manually, you would need something like the following example.

```php
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
```

This example does a lot, so lets break it down.

- The `boot()` method is where we call to load the class route directories.
- `load()` loops through each directory in the `config/route.php` `paths` array and finds any route classes you have in those 
directories.  It then loops through each and assigns the routes within as a route group.
- `convertProviderToRoutes()` is where we actually use the data in the class route to make an actual Laravel route.  We also 
assign any patterns here.

<a name="usage"></a>
## Usage

So how does this provider help us?  Let's first look at an example route class.

```php
<?php

namespace App\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;
use Illuminate\Routing\Router;

class Home extends BaseRoute implements Routes
{
    public $namespace = 'App\Http\Controllers';

    public $middleware = ['web'];

    public function routes(Router $router)
    {
        $router->get('/')
               ->name('home')
               ->uses('HomeController@index')
               ->middleware('active:home');
        
        $router->get('dashboard')
               ->name('dashboard')
               ->uses('HomeController@dashboard')
               ->middleware('active:home');
    }
}
```

This is a very basic example of a route class.  It must implement `Routes` and a lot of helpers are provided for you in 
`JumpGate\Core\Providers\Routes`.  Simply extend it if you want to.

There are a lot of properties to help define your route.

- The `$namespace` property is used to set the namespace for the route group as a whole.  The `$prefix` would be something 
that should proceed every uri.  An example is below. 
 ```php
public $prefix = 'dashboard';
```
- The `$context` property is a setting on the route that lets you use a predefined context.  Two default contexts are added 
by the `BaseRoute` class.  They are `default` and `admin`.  Default returns a `/` and `admin` returns `/admin`.  You can 
add any contexts you want at any time with the `setContext()` method.
- The `$middleware` property is an array of middleware the group will use.
- `$patterns` will set the patterns as mentioned earlier.
- Setting `$role` will force the user to have the specified role to access the route.
- Setting the `$permissions` array will require the user to have one of the permissions specified to access.

Lastly is the `routes()` method.  This is where you define all the routes this group will use.  These can look like normal routes
using the facade or you can use the new laravel 5.3+ fluent style methods.
