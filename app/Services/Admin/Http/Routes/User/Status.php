<?php

namespace App\Services\Admin\Http\Routes\User;

use App\Abstracts\Route;
use App\Contracts\Routes;
use App\Services\Users\Models\User\Status as StatusModel;
use Illuminate\Routing\Router;

class Status extends Route implements Routes
{
    public ?string $namespace = 'App\Services\Admin\Http\Controllers\User';

    public ?string $context = 'default';

    public ?string $prefix = 'admin/users/status';

    public ?string $role = 'admin';

    public array $middleware = [
        'web',
        'auth',
        'role:admin|developer',
    ];

    public function routes(Router $router)
    {
        $router->bind('statusObject', function ($id) {
            return StatusModel::find($id);
        });

        $router->get('/')
            ->name('admin.users.status.index')
            ->uses('Status@index')
            ->middleware('active:admin.users.status.index');

        $router->get('create')
            ->name('admin.users.status.create')
            ->uses('Status@create')
            ->middleware('active:admin.users.status.index');
        $router->post('create')
            ->name('admin.users.status.store')
            ->uses('Status@store');

        $router->get('edit/{statusObject}')
            ->name('admin.users.status.edit')
            ->uses('Status@edit')
            ->middleware('active:admin.users.status.index');
        $router->post('edit/{statusObject}')
            ->name('admin.users.status.update')
            ->uses('Status@update');

        $router->get('confirm/{id}/{status}/{action?}')
            ->name('admin.users.status.confirm')
            ->uses('Status@confirm')
            ->middleware('active:admin.users.status.index');
        $router->post('confirm/{id}/{status?}/{action?}')
            ->name('admin.users.status.confirmed')
            ->uses('Status@confirmed');
    }
}
