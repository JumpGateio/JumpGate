<?php

namespace App\Services\Admin\Http\Routes;

use App\Abstracts\Route;
use App\Contracts\Routes;
use Illuminate\Routing\Router;

class Artisan extends Route implements Routes
{
    public ?string $namespace = 'App\Services\Admin\Http\Controllers\Artisan';

    public ?string $context = 'default';

    public ?string $prefix = 'admin/artisan';

    // public $role = 'admin';

    public array $middleware = [
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
