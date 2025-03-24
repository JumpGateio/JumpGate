<?php

namespace App\Http\Routes;

use App\Services\JumpGate\Core\Abstracts\Route;
use App\Services\JumpGate\Core\Contracts\Routes;
use Illuminate\Routing\Router;

class Home extends Route implements Routes
{
    public ?string $namespace = 'App\Http\Controllers';

    public array $middleware = ['web'];

    public function routes(Router $router): void
    {
        $router->get('/')
               ->name('home')
               ->uses('Home@index');
    }
}
