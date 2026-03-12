<?php

namespace Database\Seeders\RBAC;

use App\Services\Users\Models\Permission;
use App\Services\Users\Models\Role;
use Database\Seeders\Base;

class Permissions extends Base
{
    public function run()
    {
        supportCollector(config('jumpgate.rbac.permissions'))
            ->filter(function ($permission) {
                return Permission::where('name', $permission['name'])->count() == 0;
            })
            ->each(function ($permission) {
                $roles      = array_pull($permission, 'roles');
                $roleIds    = Role::whereIn('name', $roles)->get()->id->toArray();
                $permission = Permission::create($permission);
                $permission->roles()->sync($roleIds);
            });
    }
}
