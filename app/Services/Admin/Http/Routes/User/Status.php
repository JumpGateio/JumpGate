<?php

namespace App\Services\Admin\Http\Routes\User;

use JumpGate\Core\Http\Routes\BaseRoute;
use JumpGate\Core\Contracts\Routes;
use App\Services\Users\Models\User\Status as StatusModel;
use Illuminate\Routing\Router;

class Status extends BaseRoute implements Routes
{
    public $namespace  = 'App\Services\Admin\Http\Controllers\User';

    public $context    = 'default';

    public $prefix     = 'admin/users/status';

    public $role       = 'admin';

    public $middleware = [
        'web',
        'auth',
        'permission:access-admin',
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
            ->middleware(['active:admin.users.status.index','permission:create-status']);
        $router->post('create')
            ->name('admin.users.status.store')
            ->uses('Status@store')
            ->middleware('permission:create-status');

        $router->get('edit/{statusObject}')
            ->name('admin.users.status.edit')
            ->uses('Status@edit')
            ->middleware(['active:admin.users.status.index','permission:update-status']);
        $router->post('edit/{statusObject}')
            ->name('admin.users.status.update')
            ->uses('Status@update')
            ->middleware('permission:update-status');

        $router->get('confirm/{id}/{status}/{action?}')
            ->name('admin.users.status.confirm')
            ->uses('Status@confirm')
            ->middleware(['active:admin.users.status.index','permission:delete-status']);
        $router->post('confirm/{id}/{status?}/{action?}')
            ->name('admin.users.status.confirmed')
            ->uses('Status@confirmed')
            ->middleware('permission:delete-status');
    }
}
