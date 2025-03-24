<?php

namespace App\Services\Users\Http\Routes;

use App\Services\JumpGate\Core\Abstracts\Route;
use App\Services\JumpGate\Core\Contracts\Routes;
use Illuminate\Routing\Router;

class Activation extends Route implements Routes
{
    public ?string $namespace = 'App\Services\Users\Http\Controllers';

    public ?string $context = 'default';

    public ?string $prefix = 'activation';

    public array $middleware = [
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

        $router->get('generate/{user_id}')
               ->name('auth.activation.generate')
               ->uses('Activation@generate');

        $router->get('inactive')
               ->name('auth.activation.inactive')
               ->uses('Activation@inactive');

        $router->get('re-send/{token}')
               ->name('auth.activation.resend')
               ->uses('Activation@resend');

        $router->get('failed/{token}')
               ->name('auth.activation.failed')
               ->uses('Activation@failed');

        $router->get('{token}')
               ->name('auth.activation.activate')
               ->uses('Activation@activate');
    }
}
