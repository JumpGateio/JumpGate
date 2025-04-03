<?php

namespace App\Services\Users\Http\Routes;

use JumpGate\Core\Http\Routes\BaseRoute;
use JumpGate\Core\Contracts\Routes;
use Illuminate\Routing\Router;

class Invitation extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Users\Http\Controllers';

    public $context = 'default';

    public $prefix = 'invitation';

    public $middleware = [
        'web',
        'auth',
    ];

    public function routes(Router $router)
    {
        if (! config('jumpgate.users.settings.allow_invitations')) {
            return true;
        }

        $this->standardAuth($router);
    }

    private function standardAuth(Router $router)
    {
        $router->get('sent')
            ->name('auth.invitation.sent')
            ->uses('Invitation@sent');

        $router->get('generate/{userId}')
            ->name('auth.invitation.generate')
            ->uses('Invitation@generate');

        $router->get('inactive')
            ->name('auth.invitation.inactive')
            ->uses('Invitation@inactive');

        $router->get('re-send/{tokenString}')
            ->name('auth.invitation.resend')
            ->uses('Invitation@resend');

        $router->get('failed/{tokenString}')
            ->name('auth.invitation.failed')
            ->uses('Invitation@failed');

        $router->get('{tokenString}')
            ->name('auth.invitation.activate')
            ->uses('Invitation@activate');
    }
}
