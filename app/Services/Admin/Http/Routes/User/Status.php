<?php

namespace App\Services\Admin\Http\Routes\User;

use App\Models\User;
use JumpGate\Core\Contracts\Routes;
use JumpGate\Core\Http\Routes\BaseRoute;
use Illuminate\Routing\Router;
use JumpGate\Users\Models\User\Status as StatusModel;

class Status extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Admin\Http\Controllers\User';

    public $context = 'default';

    public $prefix = 'admin/users/status';

    public $role = 'admin';

    public $middleware = [
        'web',
        'auth',
        'role:admin',
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
