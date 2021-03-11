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

        $router->get('/api/ziggy')
               ->name('ziggy')
               ->uses('HomeController@ziggy')
               ->middleware('active:home, auth');
    }
}
