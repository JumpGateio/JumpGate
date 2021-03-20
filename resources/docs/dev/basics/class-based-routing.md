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

You will first need to make sure your `RouteServiceProvider` can understand these classes.  In the `jumpgate/jumpgate` 
package this is done for you.  To set it up manually, you would need something like the 
[RouteServiceProvider](https://github.com/JumpGateio/JumpGate/blob/master/app/Providers/RouteServiceProvider.php) from the 
JumpGate package.

This class does a lot, so lets break it down.

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
`JumpGate\Core\Http\Routes\BaseRoute`.  Simply extend it if you want to.

There are a lot of properties to help define your route.

- The `$namespace` property is used to set the namespace for the route group as a whole.  The `$prefix` would be something 
that should proceed every uri.  An example is below.  This would mean every route in this class would be at 
`http://<site>.com/dashboard/<route>`.

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

> {warning} Once you have added this class it should begin working on the next reload.  If not, look in `config/routes.php` and make 
sure the location of your route file is defined.
