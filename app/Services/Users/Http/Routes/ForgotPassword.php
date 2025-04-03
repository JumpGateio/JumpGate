<?php

namespace App\Services\Users\Http\Routes;

use JumpGate\Core\Http\Routes\BaseRoute;
use JumpGate\Core\Contracts\Routes;
use Illuminate\Routing\Router;

class ForgotPassword extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Users\Http\Controllers';

    public $context = 'default';

    public $prefix = 'password';

    public $middleware = [
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
               ->name('auth.password.sendEmail')
               ->uses('ForgotPassword@sendEmail');

        // Finish resetting.
        $router->get('confirm/{tokenString}')
               ->name('auth.password.confirm')
               ->uses('ForgotPassword@confirm');

        $router->post('confirm/{tokenString}')
               ->name('auth.password.handle')
               ->uses('ForgotPassword@handle');
    }
}
