<?php

namespace App\Services\Users\Http\Routes;

use App\Abstracts\Route;
use App\Contracts\Routes;
use Illuminate\Routing\Router;

class ForgotPassword extends Route implements Routes
{
    public ?string $namespace = 'App\Services\Users\Http\Controllers';

    public ?string $context = 'default';

    public ?string $prefix = 'password';

    public array $middleware = [
        'web',
        // 'guest',
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
               ->name('auth.password.sent')
               ->uses('ForgotPassword@sent');

        // Trigger reset.
        $router->get('reset')
               ->name('auth.password.reset')
               ->uses('ForgotPassword@reset');

        $router->post('reset')
               ->name('auth.password.reset')
               ->uses('ForgotPassword@sendEmail');

        // Finish resetting.
        $router->get('confirm/{token}')
               ->name('auth.password.confirm')
               ->uses('ForgotPassword@confirm');

        $router->post('confirm/{token}')
               ->name('auth.password.confirm')
               ->uses('ForgotPassword@handle');
    }
}
