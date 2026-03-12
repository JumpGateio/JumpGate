<?php

namespace App\Http\Routes;

use Illuminate\Routing\Router;
use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;

class Home extends BaseRoute implements Routes
{
    public $namespace = 'App\Http\Controllers';

    public $middleware = ['web'];

    public function routes(Router $router): void
    {
        $router->get('/')
            ->name('home')
            ->uses('Home@index');
    }
}
