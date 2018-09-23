# JumpGate App Walkthrough: Routes and Links

---

- [Introduction](#introduction)
- [Routes](#routes)
- [Route Provider](#route-provider)
- [Links](#links)

<a name="introduction"></a>
## Introduction

In this step of creating our todo app, we are going to continue building out the todo service.  In this step we will be 
setting up our controllers and routes.  These all live in the `app/Services/ToDo/Http` directory.

> {info} You can see the source code at [GitHub](https://github.com/JumpGateio/ToDo-Walkthrough).

> This step is stored as a branch called [http](https://github.com/JumpGateio/ToDo-Walkthrough/tree/3-http).

<a name="routes"></a>
# Routes

In JumpGate, we use class based routing.  By this we mean that we do not use the default `routes/web.php` file to store 
routes.  Even using includes and sub directories to keep this organized more, it still felt odd to us.  So we created a 
system where we could use a PHP class as a route group.  To assist with this we have created a base route class and an 
interface.  These are pretty easy once you get used to them.

> {success} Learn more about [class based routing](/docs/{{version}}/core-class-based-routing).

All you need to get a route class started is the namespace, the middleware and the routes method.  Create a new file named 
`TaskList.php` in `app/Services/ToDo/Http/Routes`.  We will add the following needed code to get started.

```php
<?php

namespace App\Services\ToDo\Http\Routes;

use Illuminate\Routing\Router;
use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;

class TaskList extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Http\Controllers';
    
    public $middleware = [
        'web',
        'auth',
    ];

    public function routes(Router $router)
    {
        //
    }
}
```

This all behaves exactly like you are used to, just in a class instead of a flat file.  The `namespace` is used to tell Laravel 
where our controllers will be located.  The `middleware` is what middleware should be run before allowing access to these 
routes.  The `routes()` method itself is where we place our routes that the user can access.  Let's add our routes that 
we know we will need.

```php
<?php

namespace App\Services\ToDo\Http\Routes;

use Illuminate\Routing\Router;
use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;

class TaskList extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Http\Controllers';

    public $middleware = [
        'web',
        'auth',
    ];

    public function routes(Router $router)
    {
        $router->get('create')
            ->name('task-list.create')
            ->uses('TaskList@create')
            ->middleware('active:task-list.create');
        $router->post('create')
            ->name('task-list.create')
            ->uses('TaskList@store');

        $router->get('edit')
            ->name('task-list.edit')
            ->uses('TaskList@edit')
            ->middleware('active:task-list.edit');
        $router->post('edit')
            ->name('task-list.edit')
            ->uses('TaskList@update');

        $router->get('delete')
            ->name('task-list.delete')
            ->uses('TaskList@delete');

        $router->get('{id}')
            ->name('task-list.show')
            ->uses('TaskList@show')
            ->middleware('active:task-list');

        $router->get('/')
            ->name('task-list.index')
            ->uses('TaskList@index')
            ->middleware('active:task-list.index');
    }
}
```

As you can see, once inside the `routes()` method, everything behaves the same way it does in the Laravel route file.  The 
one thing that may be new is the `active:task-list` middleware.  This is part of our `Menu` package and is used to add the 
active class to your links when a user is on that route.  The view part is already handled by our menu views so you don't 
need to do any extra work to make it happen.

<a name="route-provider"></a>
# Route Provider

You may have noticed that laravel has no 


<a name="links"></a>
# Links

Let's add the links.  To do this open `app/Http/Composers/Menu.php` and go to the `generateLeftMenu()` method.  We are going 
to add our new links here.

```php

```
