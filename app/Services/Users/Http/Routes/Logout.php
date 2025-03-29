<?php

namespace App\Services\Users\Http\Routes;

use JumpGate\Core\Http\Routes\BaseRoute;
use JumpGate\Core\Contracts\Routes;
use Illuminate\Routing\Router;

class Logout extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Users\Http\Controllers';

    public $context = 'default';

    public $middleware = [
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
