<?php

namespace App\Services\Admin\Http\Routes;

use JumpGate\Core\Http\Routes\BaseRoute;
use JumpGate\Core\Contracts\Routes;
use App\Services\Users\Models\User;
use Illuminate\Routing\Router;

class Users extends BaseRoute implements Routes
{
    public $namespace = 'App\Services\Admin\Http\Controllers';

    public $context = 'default';

    public $prefix = 'admin/users';

    public $role = 'admin';

    public $middleware = [
        'web',
        'auth',
        'role:admin|developer',
    ];

    public function routes(Router $router)
    {
        $router->bind('user', function ($id) {
            return User::with(['status', 'details', 'roles'])
                ->withTrashed()
                ->find($id);
        });

        $router->get('/')
            ->name('admin.users.index')
            ->uses('Users@index')
            ->middleware('active:admin.users.index');

        $router->get('show/{user}')
            ->name('admin.users.show')
            ->uses('Users@show')
            ->middleware('active:admin.users.index');

        $router->get('create')
            ->name('admin.users.create')
            ->uses('Users@create')
            ->middleware('active:admin.users.index');
        $router->post('create')
            ->name('admin.users.store')
            ->uses('Users@store');

        $router->get('edit/{user}')
            ->name('admin.users.edit')
            ->uses('Users@edit')
            ->middleware('active:admin.users.index');
        $router->post('edit/{user}')
            ->name('admin.users.update')
            ->uses('Users@update');

        $router->get('confirm/{id}/{status}/{action?}')
            ->name('admin.users.confirm')
            ->uses('Users@confirm')
            ->middleware('active:admin.users.index');
        $router->post('confirm/{id}/{status?}/{action?}')
            ->name('admin.users.confirmed')
            ->uses('Users@confirmed');
    }
}
