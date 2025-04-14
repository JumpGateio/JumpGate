<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    protected array $permissions = [
        [
            'name'         => 'access-admin',
            'display_name' => 'Access Admin',
            'description'  => 'Access the admin area.',
            'roles'        => ['developer', 'admin'],
        ],
        [
            'name'         => 'access-pulse',
            'display_name' => 'Access Pulse',
            'description'  => 'Access the pulse dashboard.',
            'roles'        => ['developer', 'admin'],
        ],
        [
            'name'         => 'access-telescope',
            'display_name' => 'Access Telescope',
            'description'  => 'Access the telescope dashboard.',
            'roles'        => ['developer', 'admin'],
        ],
        [
            'name'         => 'create-user',
            'display_name' => 'Create New Users',
            'description'  => 'Create users in the admin area.',
            'roles'        => ['developer', 'admin'],
        ],
        [
            'name'         => 'update-user',
            'display_name' => 'Update Users',
            'description'  => 'Update users in the admin area.',
            'roles'        => ['developer', 'admin'],
        ],
        [
            'name'         => 'create-status',
            'display_name' => 'Create New User Status',
            'description'  => 'Create user statuses in the admin area.',
            'roles'        => ['developer', 'admin'],
        ],
        [
            'name'         => 'update-status',
            'display_name' => 'Update User Status',
            'description'  => 'Update user statuses in the admin area.',
            'roles'        => ['developer', 'admin'],
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        supportCollector($this->permissions)
            ->each(function ($permission) {
                $roles      = array_pull($permission, 'roles');
                $roleIds    = \App\Services\Users\Models\Role::whereIn('name', $roles)->get()->id->toArray();
                $permission = \App\Services\Users\Models\Permission::create($permission);
                $permission->roles()->sync($roleIds);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $names       = supportCollector($this->permissions)->pluck('name')->toArray();
        $permissions = \App\Services\Users\Models\Permission::whereIn('name', $names)
            ->get();

        \Illuminate\Support\Facades\DB::table('rbac_permission_role')
            ->whereIn('permission_id', $permissions->id->toArray())
            ->delete();
        \Illuminate\Support\Facades\DB::table('rbac_permission_user')
            ->whereIn('permission_id', $permissions->id->toArray())
            ->delete();
        \Illuminate\Support\Facades\DB::table('rbac_permissions')
            ->whereIn('id', $permissions->id->toArray())
            ->delete();
    }
};
