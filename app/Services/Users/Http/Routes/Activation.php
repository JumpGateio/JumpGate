<?php

namespace App\Services\Users\Http\Routes;

use JumpGate\Core\Http\Routes\BaseRoute;
use JumpGate\Core\Contracts\Routes;
use Illuminate\Routing\Router;

class Activation extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Users\Http\Controllers';

    public $context = 'default';

    public $prefix = 'activation';

    public $middleware = [
        'web',
        'guest',
    ];

    public function routes(Router $router)
    {
        if (config('jumpgate.users.social_auth_only') === false) {
            $this->standardAuth($router);
        }
    }

    private function standardAuth(Router $router)
    {
        $router->get('sent')
               ->name('auth.activation.sent')
               ->uses('Activation@sent');

        $router->get('generate/{userId}')
               ->name('auth.activation.generate')
               ->uses('Activation@generate');

        $router->get('inactive')
               ->name('auth.activation.inactive')
               ->uses('Activation@inactive');

        $router->get('re-send/{tokenString}')
               ->name('auth.activation.resend')
               ->uses('Activation@resend');

        $router->get('failed/{tokenString}')
               ->name('auth.activation.failed')
               ->uses('Activation@failed');

        $router->get('{tokenString}')
               ->name('auth.activation.activate')
               ->uses('Activation@activate');
    }
}
