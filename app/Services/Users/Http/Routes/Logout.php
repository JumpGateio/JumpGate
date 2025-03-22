<?php

namespace App\Services\Users\Http\Routes;

use App\Abstracts\Route;
use App\Contracts\Routes;
use Illuminate\Routing\Router;

class Logout extends Route implements Routes
{
    public ?string $namespace = 'App\Services\Users\Http\Controllers';

    public ?string $context = 'default';

    public array $middleware = [
        'web',
        'auth',
    ];

    public function routes(Router $router)
    {
        $router->get('logout')
               ->name('auth.logout')
               ->uses('Authentication@logout');
    }
}
