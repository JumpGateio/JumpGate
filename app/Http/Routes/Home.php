<?php

namespace App\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Providers\Routes as BaseRoutes;
use Illuminate\Routing\Router;

class Home extends BaseRoutes implements Routes
{
    public function namespacing()
    {
        return 'App\Http\Controllers';
    }

    public function prefix()
    {
        return null;
    }

    public function middleware()
    {
        return ['web'];
    }

    public function patterns()
    {
        return [];
    }

    public function routes(Router $router)
    {
        $router->get('/')
               ->name('home')
               ->uses('HomeController@index')
               ->middleware('active:home');
    }
}
