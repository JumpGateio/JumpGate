<?php

namespace Database\Seeders\RBAC;

use Database\Seeders\Base;

class Permissions extends Base
{
    public function run()
    {
        supportCollector(config('jumpgate.rbac.permissions'))
            ->filter(function ($permission) {
                return \App\Services\Users\Models\Permission::where('name', $permission['name'])->count() == 0;
            })
            ->each(function ($permission) {
                $roles      = array_pull($permission, 'roles');
                $roleIds    = \App\Services\Users\Models\Role::whereIn('name', $roles)->get()->id->toArray();
                $permission = \App\Services\Users\Models\Permission::create($permission);
                $permission->roles()->sync($roleIds);
            });
    }
}
