<?php

namespace App\Services\Users\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;
use Illuminate\Routing\Router;

class Registration extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Users\Http\Controllers';

    public $context = 'default';

    public $middleware = [
        'web',
        'guest',
    ];

    public function routes(Router $router)
    {
        // If the site has disabled registration, don't register these routes.
        if (! config('jumpgate.users.settings.allow_registration')) {
            return true;
        }

        $this->standardAuth($router);
    }

    private function standardAuth(Router $router)
    {
        $router->get('register')
               ->name('auth.register')
               ->uses('Registration@index');
        $router->post('register')
               ->name('auth.register')
               ->uses('Registration@handle');
    }
}
