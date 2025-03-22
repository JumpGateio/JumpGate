<?php

namespace App\Services\Users\Http\Routes;

use App\Abstracts\Route;
use App\Contracts\Routes;
use Illuminate\Routing\Router;

class Registration extends Route implements Routes
{
    public ?string $namespace = 'App\Services\Users\Http\Controllers';

    public ?string $context = 'default';

    public array $middleware = [
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
