<?php

namespace App\Services\Admin\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;
use Illuminate\Routing\Router;

class Index extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Admin\Http\Controllers';

    public $context = 'default';

    public $prefix = 'admin';

    public $role = 'admin';

    public $middleware = [
        'web',
        'auth',
        'role:admin|developer',
    ];

    public function routes(Router $router)
    {
        $router->get('/')
            ->name('admin.index')
            ->uses('Index')
            ->middleware('active:admin.dashboard');

        $router->get('/tiles/users')
            ->name('admin.index.users')
            ->uses('Index@users')
            ->middleware('active:admin.dashboard');
    }
}
