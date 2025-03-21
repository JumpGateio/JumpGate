<?php

namespace App\Http\Routes;

use App\Contracts\Routes;
use Illuminate\Routing\Router;

class Home extends Base implements Routes
{
    public ?string $namespace = 'App\Http\Controllers';

    public array $middleware = ['web'];

    public function routes(Router $router): void
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
