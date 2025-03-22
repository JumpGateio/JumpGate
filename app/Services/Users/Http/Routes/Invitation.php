<?php

namespace App\Services\Users\Http\Routes;

use App\Abstracts\Route;
use App\Contracts\Routes;
use Illuminate\Routing\Router;

class Invitation extends Route implements Routes
{
    public ?string $namespace = 'App\Services\Users\Http\Controllers';

    public ?string $context = 'default';

    public ?string $prefix = 'invitation';

    public array $middleware = [
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

        $router->get('generate/{user_id}')
            ->name('auth.invitation.generate')
            ->uses('Invitation@generate');

        $router->get('inactive')
            ->name('auth.invitation.inactive')
            ->uses('Invitation@inactive');

        $router->get('re-send/{token}')
            ->name('auth.invitation.resend')
            ->uses('Invitation@resend');

        $router->get('failed/{token}')
            ->name('auth.invitation.failed')
            ->uses('Invitation@failed');

        $router->get('{token}')
            ->name('auth.invitation.activate')
            ->uses('Invitation@activate');
    }
}
