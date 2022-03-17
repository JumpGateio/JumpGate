<?php

namespace App\Services\Admin\Http\Routes;

use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;
use Illuminate\Routing\Router;

class Artisan extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Admin\Http\Controllers\Artisan';

    public $context = 'default';

    public $prefix = 'admin/artisan';

    // public $role = 'admin';

    public $middleware = [
        'web',
        'auth',
        'role:admin|developer',
    ];

    public function routes(Router $router)
    {
        $router->get('/')
            ->name('admin.artisan.index')
            ->uses('Index')
            ->middleware('active:admin.artisan');

        $router->any('run')
            ->name('admin.artisan.run')
            ->uses('Run')
            ->middleware('active:admin.artisan');
    }
}
