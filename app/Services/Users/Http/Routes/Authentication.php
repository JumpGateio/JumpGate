<?php

namespace App\Services\Users\Http\Routes;

use JumpGate\Core\Http\Routes\BaseRoute;
use JumpGate\Core\Contracts\Routes;
use Illuminate\Routing\Router;

class Authentication extends BaseRoute implements Routes
{
    public $namespace  = 'App\Services\Users\Http\Controllers';

    public $context    = 'default';

    public $middleware = [
        'web',
        'guest',
    ];

    public function routes(Router $router)
    {
        if (config('jumpgate.users.social_auth_only') == false) {
            $this->standardAuth($router);
        }

        if (config('jumpgate.users.enable_social') == true) {
            $this->socialAuth($router);
        }

        $router->get('blocked')
            ->name('auth.blocked')
            ->uses('Authentication@blocked');
    }

    private function standardAuth(Router $router)
    {
        $router->get('login')
            ->name('auth.login')
            ->uses('Authentication@index')
            ->middleware('active:login');
        $router->post('login')
            ->name('auth.login')
            ->uses('Authentication@handle');
    }

    private function socialAuth(Router $router)
    {
        // Login
        $router->get('login/{provider?}')
            ->name('auth.social.login')
            ->uses('SocialAuthentication@login');

        $router->get('callback/{provider}')
            ->name('auth.social.callback')
            ->uses('SocialAuthentication@callback');
    }
}
