<?php

namespace App\Services\Admin\Http\Routes;

use App\Services\JumpGate\Core\Abstracts\Route;
use App\Services\JumpGate\Core\Contracts\Routes;
use Illuminate\Routing\Router;

class Index extends Route implements Routes
{
    public ?string $namespace = 'App\Services\Admin\Http\Controllers';

    public ?string $context = 'default';

    public ?string $prefix = 'admin';

    public ?string $role = 'admin';

    public array $middleware = [
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
